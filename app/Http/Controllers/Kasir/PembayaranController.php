<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pembayaran;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function indexDaftarTagihan()
    {
        $kunjungansSiapBayar = Kunjungan::with(['pasien', 'pembayaran'])
                                    ->where('status_kunjungan', 'Menunggu Pembayaran')
                                    ->orderBy('tanggal_kunjungan', 'asc')
                                    ->paginate(10);

        return view('kasir.pembayaran.index_daftar_tagihan', compact('kunjungansSiapBayar'));
    }

    public function showFormPembayaran(Kunjungan $kunjungan)
    {
        $kunjungan->load(['pasien', 'daftarTindakan.tindakan', 'daftarObat.obat']);

        $pembayaran = Pembayaran::firstOrCreate(
            ['kunjungan_id' => $kunjungan->id],
            [
                'no_tagihan' => $this->generateNoTagihan(),
                'tanggal_tagihan' => now(),
                'status_pembayaran' => 'Belum Lunas',
                'subtotal' => 0,
                'total_setelah_diskon' => 0,
                'grand_total' => 0,
            ]
        );

        $totalBiayaTindakan = 0;
        foreach ($kunjungan->daftarTindakan as $itemTindakan) {
            $totalBiayaTindakan += $itemTindakan->harga_saat_transaksi * $itemTindakan->jumlah;
        }

        $totalBiayaObat = 0;
        foreach ($kunjungan->daftarObat as $itemObat) {
            $totalBiayaObat += $itemObat->harga_jual_saat_transaksi * $itemObat->jumlah_obat;
        }

        $pembayaran->total_biaya_tindakan = $totalBiayaTindakan;
        $pembayaran->total_biaya_obat = $totalBiayaObat;

        $pembayaran->subtotal = $totalBiayaTindakan + $totalBiayaObat + ($pembayaran->biaya_tambahan ?? 0);

        $diskon = 0;
        if (($pembayaran->diskon_persen ?? 0) > 0) {
            $diskon = ($pembayaran->subtotal * $pembayaran->diskon_persen) / 100;
        } elseif (($pembayaran->diskon_nominal ?? 0) > 0) {
            $diskon = $pembayaran->diskon_nominal;
        }

        $pembayaran->total_setelah_diskon = $pembayaran->subtotal - $diskon;
        $pembayaran->grand_total = $pembayaran->total_setelah_diskon;

        if ($pembayaran->isDirty() || !$pembayaran->exists) {
             $pembayaran->save();
        }

        $metodePembayaranOptions = ['Tunai', 'Kartu Debit', 'Kartu Kredit', 'QRIS', 'Transfer Bank', 'Asuransi'];

        return view('kasir.pembayaran.form_pembayaran', compact(
            'kunjungan',
            'pembayaran',
            'metodePembayaranOptions'
        ));
    }

    /**
     * Helper function untuk generate Nomor Tagihan Unik.
     */
    private function generateNoTagihan()
    {
        $today = Carbon::now()->format('Ymd');
        $prefix = 'INV/' . $today . '/';

        $lastTagihanToday = Pembayaran::where('no_tagihan', 'LIKE', $prefix . '%')->orderBy('no_tagihan', 'desc')->first();

        $nextSequence = 1;
        if ($lastTagihanToday) {
            $lastSequence = (int) substr($lastTagihanToday->no_tagihan, strlen($prefix));
            $nextSequence = $lastSequence + 1;
        }
        
        return $prefix . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
    }

    public function prosesPembayaran(Request $request, Kunjungan $kunjungan)
    {
        $validatedData = $request->validate([
            'pembayaran_id' => 'required|exists:pembayaran,id',
            'biaya_tambahan' => 'nullable|numeric|min:0',
            'keterangan_biaya_tambahan' => 'nullable|string|max:255',
            'diskon_nominal' => 'nullable|numeric|min:0',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|max:50',
            'nomor_referensi_pembayaran' => 'nullable|string|max:255',
            'catatan_pembayaran' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $pembayaran = Pembayaran::findOrFail($validatedData['pembayaran_id']);

            if ($pembayaran->kunjungan_id !== $kunjungan->id) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Kesalahan: Pembayaran tidak sesuai dengan kunjungan.');
            }

            $pembayaran->biaya_tambahan = $validatedData['biaya_tambahan'] ?? $pembayaran->biaya_tambahan;
            $pembayaran->keterangan_biaya_tambahan = $validatedData['keterangan_biaya_tambahan'] ?? $pembayaran->keterangan_biaya_tambahan;
            $pembayaran->diskon_nominal = $validatedData['diskon_nominal'] ?? $pembayaran->diskon_nominal;

            $pembayaran->subtotal = $pembayaran->total_biaya_tindakan + $pembayaran->total_biaya_obat + $pembayaran->biaya_tambahan;

            $diskon = $pembayaran->diskon_nominal;

            // if (($validatedData['diskon_persen'] ?? $pembayaran->diskon_persen ?? 0) > 0) {
            //     $pembayaran->diskon_persen = $validatedData['diskon_persen'] ?? $pembayaran->diskon_persen;
            //     $diskon = ($pembayaran->subtotal * $pembayaran->diskon_persen) / 100;
            //     // Jika diskon persen diisi, mungkin nolkan diskon nominal atau sebaliknya
            //     // $pembayaran->diskon_nominal = 0; 
            // } else {
            //     $pembayaran->diskon_persen = 0;
            // }

            $pembayaran->total_setelah_diskon = $pembayaran->subtotal - $diskon;
            $pembayaran->grand_total = $pembayaran->total_setelah_diskon;

            if ($validatedData['jumlah_bayar'] < $pembayaran->grand_total) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Jumlah bayar kurang dari total tagihan (Rp ' . number_format($pembayaran->grand_total, 0, ',', '.') . ').');
            }

            $pembayaran->jumlah_bayar = $validatedData['jumlah_bayar'];
            $pembayaran->kembalian = $validatedData['jumlah_bayar'] - $pembayaran->grand_total;
            $pembayaran->metode_pembayaran = $validatedData['metode_pembayaran'];
            $pembayaran->nomor_referensi_pembayaran = $validatedData['nomor_referensi_pembayaran'];
            $pembayaran->catatan_pembayaran = $validatedData['catatan_pembayaran'];

            $pembayaran->status_pembayaran = 'Lunas';
            $pembayaran->tanggal_pembayaran_lunas = now();

            $kasirPegawai = Auth::user()->pegawai;
            
            if ($kasirPegawai) {
                $pembayaran->kasir_id = $kasirPegawai->id;
            } else {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Data kasir tidak ditemukan. Hubungi Administrator.');
            }

            $pembayaran->save();

            $kunjungan->status_kunjungan = 'Selesai';
            $kunjungan->save();

            DB::commit();

            return redirect()->route('kasir.tagihan.bayar.form', $kunjungan->id)
                            ->with('success', 'Pembayaran berhasil diproses! Kembalian: Rp ' . number_format($pembayaran->kembalian, 0, ',', '.'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi. Pesan: ' . $e->getMessage());
        }
    }
}