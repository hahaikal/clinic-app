<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function create(Request $request) 
    {
        $wilayahs = Wilayah::orderBy('nama_wilayah', 'asc')->get();
        $jenisKunjunganOptions = ['Umum', 'Gigi', 'KIA', 'Laboratorium', 'Spesialis Anak', 'Spesialis Penyakit Dalam'];
        
        $pasienDitemukan = null;
        if ($request->session()->has('pasienDitemukan')) {
            $pasienDitemukan = $request->session()->get('pasienDitemukan');
        }

        return view('petugas.pendaftaran.create', compact('wilayahs', 'jenisKunjunganOptions', 'pasienDitemukan'));
    }

    public function store(Request $request)
    {
        $validatedDataPasien = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:pasien,nik',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat_lengkap' => 'required|string',
            'wilayah_id' => 'nullable|exists:wilayahs,id',
            'telepon' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50', 
            'status_pernikahan' => 'nullable|string|max:50',
            'golongan_darah' => 'nullable|string|max:5',
            'alergi_obat' => 'nullable|string',
        ]);

        $validatedDataKunjungan = $request->validate([
            'jenis_kunjungan' => 'required|string|max:100',
            'keluhan_utama' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $today = Carbon::now()->format('Ymd');
            $lastPasienToday = Pasien::where('no_rm', 'LIKE', $today . '-%')->orderBy('no_rm', 'desc')->first();
            $nextSequence = 1;
            if ($lastPasienToday) {
                $lastSequence = (int) substr($lastPasienToday->no_rm, -3);
                if (strlen($lastPasienToday->no_rm) > 9) {
                    $lastSequence = (int) substr($lastPasienToday->no_rm, 9);
                }

                $nextSequence = $lastSequence + 1;
            }
            
            $no_rm = $today . '-' . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);
            $dataToCreatePasien = array_merge($validatedDataPasien, ['no_rm' => $no_rm]);
            $pasien = Pasien::create($dataToCreatePasien);

            $pegawaiPendaftar = Pegawai::where('user_id', Auth::id())->first();
            if (!$pegawaiPendaftar) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Data petugas pendaftar tidak ditemukan. Harap hubungi Administrator.');
            }

            $no_kunjungan = $pasien->no_rm . '-' . Carbon::now()->format('YmdHis');

            $kunjungan = Kunjungan::create([
                'pasien_id' => $pasien->id,
                'no_kunjungan' => $no_kunjungan,
                'tanggal_kunjungan' => Carbon::now(),
                'jenis_kunjungan' => $validatedDataKunjungan['jenis_kunjungan'],
                'keluhan_utama' => $validatedDataKunjungan['keluhan_utama'],
                'pegawai_id_pendaftar' => $pegawaiPendaftar->id,
                'status_kunjungan' => 'Menunggu Antrian Poli',
            ]);

            DB::commit();

            return redirect()->route('petugas.pendaftaran.pasien.create')
                            ->with('success', 'Pasien ' . $pasien->nama_pasien . ' (No. RM: ' . $pasien->no_rm . ') dan kunjungan awal berhasil didaftarkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftarkan pasien. Silakan coba lagi atau hubungi Administrator. Detail: ' . $e->getMessage());
        }
    }

    public function searchPasien(Request $request)
    {
        $query = $request->input('query');
        $pasienDitemukan = null;

        if ($query) {
            $pasienDitemukan = Pasien::where('no_rm', 'LIKE', "%{$query}%")
                                ->orWhere('nik', 'LIKE', "%{$query}%")
                                ->orWhere('nama_pasien', 'LIKE', "%{$query}%")
                                ->first();
        }

        if ($pasienDitemukan) {
            $request->session()->flash('pasienDitemukan', $pasienDitemukan);
            return redirect()->route('petugas.pendaftaran.pasien.create', ['query' => $query]);
        } else {
            return redirect()->route('petugas.pendaftaran.pasien.create', ['query' => $query])
                            ->with('error_pasien_lama', 'Pasien dengan kriteria "'.$query.'" tidak ditemukan.');
        }
    }

    public function storeKunjunganPasienLama(Request $request, Pasien $pasien)
    {
        $validatedDataKunjungan = $request->validate([
            'jenis_kunjungan' => 'required|string|max:100',
            'keluhan_utama' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $pegawaiPendaftar = Pegawai::where('user_id', Auth::id())->first();
            if (!$pegawaiPendaftar) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error_pasien_lama', 'Data petugas pendaftar tidak ditemukan. Harap hubungi Administrator.');
            }

            $no_kunjungan = $pasien->no_rm . '-' . Carbon::now()->format('YmdHis');

            Kunjungan::create([
                'pasien_id' => $pasien->id,
                'no_kunjungan' => $no_kunjungan,
                'tanggal_kunjungan' => Carbon::now(),
                'jenis_kunjungan' => $validatedDataKunjungan['jenis_kunjungan'],
                'keluhan_utama' => $validatedDataKunjungan['keluhan_utama'],
                'pegawai_id_pendaftar' => $pegawaiPendaftar->id,
                'status_kunjungan' => 'Menunggu Antrian Poli',
            ]);

            DB::commit();

            return redirect()->route('petugas.pendaftaran.pasien.create')
                            ->with('success', 'Kunjungan untuk pasien ' . $pasien->nama_pasien . ' (No. RM: ' . $pasien->no_rm . ') berhasil didaftarkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error_pasien_lama', 'Gagal mendaftarkan kunjungan untuk pasien lama. Silakan coba lagi. Pesan: ' . $e->getMessage());
        }
    }
}