<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];
        $roleName = $user->role->name ?? 'Unknown';

        switch ($roleName) {
            case 'Admin':
                $data = [
                    'totalPasien' => Pasien::count(),
                    'kunjunganHariIni' => Kunjungan::whereDate('tanggal_kunjungan', Carbon::today())->count(),
                    'totalUser' => User::count(),
                    'pendapatanHariIni' => Pembayaran::where('status_pembayaran', 'Lunas')
                                                ->whereDate('tanggal_pembayaran_lunas', Carbon::today())
                                                ->sum('grand_total'),
                ];
                break;
            case 'Petugas Pendaftaran':
                $data = [
                    'pasienBaruHariIni' => Pasien::whereDate('created_at', Carbon::today())->count(),
                    'antrianPoli' => Kunjungan::where('status_kunjungan', 'Menunggu Antrian Poli')
                                            ->whereDate('tanggal_kunjungan', Carbon::today())
                                            ->count(),
                ];
                break;
            case 'Dokter':
                $pegawaiDokterId = $user->pegawai ? $user->pegawai->id : null;
                $data = [
                    'menungguPemeriksaan' => Kunjungan::where('status_kunjungan', 'Menunggu Antrian Poli')
                                                    // ->orWhere(function($query) use ($pegawaiDokterId) {
                                                    //     if ($pegawaiDokterId) {
                                                    //         $query->where('dokter_id', $pegawaiDokterId)
                                                    //               ->where('status_kunjungan', 'Menunggu Pemeriksaan');
                                                    //     }
                                                    // })
                                                    ->whereDate('tanggal_kunjungan', Carbon::today())
                                                    ->count(),
                    'pemeriksaanSelesaiHariIni' => Kunjungan::where('dokter_id', $pegawaiDokterId)
                                                        ->whereIn('status_kunjungan', ['Menunggu Pembayaran', 'Selesai'])
                                                        ->whereDate('updated_at', Carbon::today())
                                                        ->count(),
                ];
                break;
            case 'Kasir':
                $data = [
                    'tagihanMenungguPembayaran' => Kunjungan::where('status_kunjungan', 'Menunggu Pembayaran')->count(),
                    'transaksiLunasHariIni' => Pembayaran::where('status_pembayaran', 'Lunas')
                                                    ->whereDate('tanggal_pembayaran_lunas', Carbon::today())
                                                    ->count(),
                    'totalPembayaranHariIni' => Pembayaran::where('status_pembayaran', 'Lunas')
                                                    ->whereDate('tanggal_pembayaran_lunas', Carbon::today())
                                                    ->sum('grand_total'),
                ];
                break;
        }

        return view('dashboard', compact('user', 'data', 'roleName'));
    }
}