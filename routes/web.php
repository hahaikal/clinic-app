<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\TindakanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('role:Admin')->name('admin.')->prefix('admin')->group(function () {
        Route::resource('wilayah', WilayahController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('users', UserController::class);
        Route::resource('tindakan', TindakanController::class);

        Route::get('/admin/users', function () {
            return "Halaman Pengelolaan User (Khusus Admin)";
        })->middleware('role:Admin')->name('admin.users.index');

        Route::get('/admin/wilayah', function () {
            return "Halaman Pengelolaan Wilayah (Khusus Admin)";
        })->middleware('role:Admin')->name('admin.wilayah.index');
    });

    Route::get('/dokter/pemeriksaan', function () {
        return "Halaman Pemeriksaan Pasien (Khusus Dokter)";
    })->middleware('role:Dokter')->name('dokter.pemeriksaan');

    Route::get('/staff/laporan-klinik', function () {
        return "Halaman Laporan Klinik (Untuk Admin & Dokter)";
    })->middleware('role:Admin,Dokter')->name('staff.laporan');

    Route::get('/pendaftaran/pasien-baru', function () {
        return "Halaman Pendaftaran Pasien Baru (Khusus Petugas Pendaftaran)";
    })->middleware('role:Petugas Pendaftaran')->name('pendaftaran.pasien.baru');

    Route::get('/kasir/pembayaran', function () {
        return "Halaman Pembayaran Pasien (Khusus Kasir)";
    })->middleware('role:Kasir')->name('kasir.pembayaran');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
