<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function show(Pasien $pasien)
    {
        $pasien->load(['wilayah']);

        $riwayatKunjungan = Kunjungan::where('pasien_id', $pasien->id)
                                    ->with('dokter')
                                    ->orderBy('tanggal_kunjungan', 'desc')
                                    ->paginate(10);

        return view('petugas.pasien.show', compact('pasien', 'riwayatKunjungan'));
    }
}
