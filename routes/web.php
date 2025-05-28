<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\TindakanController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\LaporanController;

use App\Http\Controllers\Petugas\PendaftaranController;

use App\Http\Controllers\Dokter\PelayananController;

use App\Http\Controllers\Kasir\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('role:Admin')->name('admin.')->prefix('admin')->group(function () {
        Route::resource('wilayah', WilayahController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('users', UserController::class);
        Route::resource('tindakan', TindakanController::class);
        Route::resource('obat', ObatController::class);
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    Route::middleware('role:Petugas Pendaftaran')->name('petugas.pendaftaran.')->prefix('petugas/pendaftaran')->group(function () {
        Route::get('pasien-baru', [PendaftaranController::class, 'create'])->name('pasien.create');
        Route::post('pasien-baru', [PendaftaranController::class, 'store'])->name('pasien.store');
        Route::get('pasien-lama/search', [PendaftaranController::class, 'searchPasien'])->name('pasien.search');
        Route::post('pasien-lama/{pasien}/kunjungan', [PendaftaranController::class, 'storeKunjunganPasienLama'])->name('kunjungan.lama.store');
    });

    Route::middleware('role:Dokter')->name('dokter.')->prefix('dokter')->group(function () {
        Route::get('kunjungan-pasien', [PelayananController::class, 'indexKunjungan'])->name('kunjungan.index');
        Route::get('kunjungan/{kunjungan}/pemeriksaan', [PelayananController::class, 'showPemeriksaanForm'])->name('kunjungan.pemeriksaan.form');
        Route::post('kunjungan/{kunjungan}/tindakan', [PelayananController::class, 'storeTindakan'])->name('kunjungan.tindakan.store');
        Route::delete('kunjungan/tindakan/{kunjunganTindakan}', [PelayananController::class, 'destroyTindakan'])->name('kunjungan.tindakan.destroy');
        Route::post('kunjungan/{kunjungan}/obat', [PelayananController::class, 'storeObat'])->name('kunjungan.obat.store');
        Route::delete('kunjungan/obat/{kunjunganObat}', [PelayananController::class, 'destroyObat'])->name('kunjungan.obat.destroy');
        Route::post('kunjungan/{kunjungan}/selesai-pemeriksaan', [PelayananController::class, 'selesaiPemeriksaan'])->name('kunjungan.pemeriksaan.selesai');
    });

    Route::middleware('role:Kasir')->name('kasir.')->prefix('kasir')->group(function () {
        Route::get('daftar-tagihan', [PembayaranController::class, 'indexDaftarTagihan'])->name('tagihan.index');
        Route::get('tagihan/{kunjungan}/bayar', [PembayaranController::class, 'showFormPembayaran'])->name('tagihan.bayar.form');
        Route::post('tagihan/{kunjungan}/proses', [PembayaranController::class, 'prosesPembayaran'])->name('tagihan.proses');
    });

    Route::middleware('role:Petugas Pendaftaran,Dokter')->name('shared.')->prefix('shared')->group(function () {
        Route::get('pasien/{pasien}', [\App\Http\Controllers\Petugas\PasienController::class, 'show'])->name('pasien.show');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
