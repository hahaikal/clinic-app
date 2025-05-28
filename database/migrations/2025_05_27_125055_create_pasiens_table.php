<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique()->comment('Nomor Rekam Medis');
            $table->string('nama_pasien');
            $table->string('nik', 16)->unique()->nullable()->comment('Nomor Induk Kependudukan');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat_lengkap');
            $table->foreignId('wilayah_id')->nullable()->constrained('wilayahs')->onDelete('set null');
            $table->string('telepon', 20)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('status_pernikahan', 50)->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->text('alergi_obat')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('telepon_penanggung_jawab', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
