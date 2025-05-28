<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Tindakan;
use App\Models\Obat;   
use App\Models\KunjunganTindakan;
use App\Models\KunjunganObat;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelayananController extends Controller
{
    public function indexKunjungan()
    {
        $dokterPegawaiId = Auth::user()->pegawai ? Auth::user()->pegawai->id : null;

        $kunjungans = Kunjungan::with(['pasien', 'dokter'])
                            ->where('status_kunjungan', 'Menunggu Antrian Poli')
                            ->orWhere(function($query) use ($dokterPegawaiId) {
                                if ($dokterPegawaiId) {
                                    $query->where('dokter_id', $dokterPegawaiId)
                                          ->whereIn('status_kunjungan', ['Menunggu Pemeriksaan', 'Sedang Diperiksa']);
                                }
                            })
                            ->orderBy('tanggal_kunjungan', 'asc')
                            ->paginate(10);

        return view('dokter.pelayanan.index_kunjungan', compact('kunjungans'));
    }

    public function showPemeriksaanForm(Kunjungan $kunjungan)
    {
        $kunjungan->load([
            'pasien.wilayah',
            'daftarTindakan.tindakan',
            'daftarObat.obat'
        ]);

        $masterTindakans = Tindakan::orderBy('nama_tindakan', 'asc')->get();
        $masterObats = Obat::orderBy('nama_obat', 'asc')->get();

        if (in_array($kunjungan->status_kunjungan, ['Menunggu Antrian Poli', 'Menunggu Pemeriksaan'])) {
            $kunjungan->status_kunjungan = 'Sedang Diperiksa';
            if (is_null($kunjungan->dokter_id) && Auth::user()->pegawai) {
                $kunjungan->dokter_id = Auth::user()->pegawai->id;
            }
            $kunjungan->save();
        }

        return view('dokter.pelayanan.form_pemeriksaan', compact(
            'kunjungan',
            'masterTindakans',
            'masterObats'
        ));
    }

    public function storeTindakan(Request $request, Kunjungan $kunjungan)
    {
        $validatedData = $request->validate([
            'tindakan_id' => 'required|exists:tindakan,id',
            'jumlah' => 'required|integer|min:1',
            'catatan_tindakan' => 'nullable|string|max:255',
        ]);

        $tindakanMaster = Tindakan::find($validatedData['tindakan_id']);
        if (!$tindakanMaster) {
            return redirect()->back()->with('error', 'Data master tindakan tidak ditemukan.');
        }
        $hargaSaatTransaksi = $tindakanMaster->harga;

        try {
            KunjunganTindakan::create([
                'kunjungan_id' => $kunjungan->id,
                'tindakan_id' => $validatedData['tindakan_id'],
                'jumlah' => $validatedData['jumlah'],
                'harga_saat_transaksi' => $hargaSaatTransaksi,
                'catatan_tindakan' => $validatedData['catatan_tindakan'],
            ]);

            return redirect()->route('dokter.kunjungan.pemeriksaan.form', $kunjungan->id)
                            ->with('success', 'Tindakan medis berhasil ditambahkan ke kunjungan.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                            ->with('error', 'Gagal menambahkan tindakan medis. Silakan coba lagi.');
        }
    }

    public function storeObat(Request $request, Kunjungan $kunjungan)
    {
        $validatedData = $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah_obat' => 'required|integer|min:1',
            'dosis' => 'nullable|string|max:100',
            'aturan_pakai' => 'nullable|string|max:255',
            'catatan_resep' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $obatMaster = Obat::findOrFail($validatedData['obat_id']);

            if ($obatMaster->stok < $validatedData['jumlah_obat']) {
                DB::rollBack();
                return redirect()->back()->withInput()
                                ->with('error', 'Stok obat "' . $obatMaster->nama_obat . '" tidak mencukupi. Stok saat ini: ' . $obatMaster->stok);
            }

            $hargaJualSaatTransaksi = $obatMaster->harga_jual;

            KunjunganObat::create([
                'kunjungan_id' => $kunjungan->id,
                'obat_id' => $validatedData['obat_id'],
                'jumlah_obat' => $validatedData['jumlah_obat'],
                'dosis' => $validatedData['dosis'],
                'aturan_pakai' => $validatedData['aturan_pakai'],
                'harga_jual_saat_transaksi' => $hargaJualSaatTransaksi,
                'catatan_resep' => $validatedData['catatan_resep'],
            ]);

            $obatMaster->stok -= $validatedData['jumlah_obat'];
            $obatMaster->save();

            DB::commit();

            return redirect()->route('dokter.kunjungan.pemeriksaan.form', $kunjungan->id)
                            ->with('success', 'Obat berhasil ditambahkan ke resep.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data master obat tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                            ->with('error', 'Gagal menambahkan obat ke resep. Silakan coba lagi. Pesan: '.$e->getMessage());
        }
    }

    public function destroyTindakan(KunjunganTindakan $kunjunganTindakan) 
    {
        try {
            $kunjungan_id = $kunjunganTindakan->kunjungan_id;

            $kunjunganTindakan->delete();

            return redirect()->route('dokter.kunjungan.pemeriksaan.form', $kunjungan_id)
                            ->with('success', 'Tindakan medis berhasil dihapus dari kunjungan.');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal menghapus tindakan medis. Silakan coba lagi.');
        }
    }

    public function destroyObat(KunjunganObat $kunjunganObat) 
    {
        DB::beginTransaction();

        try {
            $kunjungan_id = $kunjunganObat->kunjungan_id;
            $obatMaster = Obat::findOrFail($kunjunganObat->obat_id);
            $jumlahObatDihapus = $kunjunganObat->jumlah_obat;

            $kunjunganObat->delete();

            $obatMaster->stok += $jumlahObatDihapus;
            $obatMaster->save();

            DB::commit();

            return redirect()->route('dokter.kunjungan.pemeriksaan.form', $kunjungan_id)
                            ->with('success', 'Obat berhasil dihapus dari resep dan stok telah dikembalikan.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data master obat tidak ditemukan saat mencoba mengembalikan stok.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->with('error', 'Gagal menghapus obat dari resep. Silakan coba lagi.');
        }
    }

    public function selesaiPemeriksaan(Request $request, Kunjungan $kunjungan)
    {
        $validatedData = $request->validate([
            'anamnesis' => 'nullable|string',
            'tinggi_badan_cm' => 'nullable|integer|min:0',
            'berat_badan_kg' => 'nullable|numeric|min:0',
            'suhu_badan_celsius' => 'nullable|numeric|min:0',
            'sistole_mmhg' => 'nullable|integer|min:0',
            'diastole_mmhg' => 'nullable|integer|min:0',
            'frekuensi_nadi_per_menit' => 'nullable|integer|min:0',
            'frekuensi_nafas_per_menit' => 'nullable|integer|min:0',
            'status_kunjungan_baru' => 'required|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            if ($request->filled('anamnesis')) {
                $kunjungan->anamnesis = $validatedData['anamnesis'];
            }

            $vitalSigns = [
                'tinggi_badan_cm', 'berat_badan_kg', 'suhu_badan_celsius',
                'sistole_mmhg', 'diastole_mmhg', 'frekuensi_nadi_per_menit', 'frekuensi_nafas_per_menit'
            ];

            foreach ($vitalSigns as $vital) {
                if ($request->filled($vital) && isset($validatedData[$vital])) {
                    $kunjungan->{$vital} = $validatedData[$vital];
                }
            }

            $kunjungan->status_kunjungan = $validatedData['status_kunjungan_baru'];

            if (is_null($kunjungan->dokter_id) && Auth::user()->pegawai) {
                $kunjungan->dokter_id = Auth::user()->pegawai->id;
            }

            $kunjungan->save();

            DB::commit();

            return redirect()->route('dokter.kunjungan.index')
                            ->with('success', 'Pemeriksaan untuk pasien ' . $kunjungan->pasien->nama_pasien . ' (Kunjungan: ' . $kunjungan->no_kunjungan . ') telah selesai.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                            ->with('error', 'Gagal menyelesaikan pemeriksaan. Silakan coba lagi. Pesan: ' . $e->getMessage());
        }
    }
}