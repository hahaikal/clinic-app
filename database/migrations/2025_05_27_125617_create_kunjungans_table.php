<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->string('no_kunjungan')->unique()->comment('Nomor unik per kunjungan');
            $table->dateTime('tanggal_kunjungan')->useCurrent();
            $table->string('jenis_kunjungan');
            $table->text('keluhan_utama')->nullable();

            // Kolom untuk data pemeriksaan awal (vital sign)
            $table->integer('tinggi_badan_cm')->nullable();
            $table->decimal('berat_badan_kg', 5, 2)->nullable();
            $table->decimal('suhu_badan_celsius', 4, 1)->nullable();
            $table->integer('sistole_mmhg')->nullable();
            $table->integer('diastole_mmhg')->nullable();
            $table->integer('frekuensi_nadi_per_menit')->nullable();
            $table->integer('frekuensi_nafas_per_menit')->nullable();

            // Penanggung jawab proses
            $table->foreignId('pegawai_id_pendaftar')->constrained('pegawai')->onDelete('restrict');
            $table->foreignId('dokter_id')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->string('status_kunjungan')->default('Menunggu Pendaftaran');
            $table->text('anamnesis')->nullable();
            $table->text('catatan_tambahan_pendaftaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
