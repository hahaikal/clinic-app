<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungan')->onDelete('cascade');
            $table->foreignId('tindakan_id')->constrained('tindakan')->onDelete('restrict');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_saat_transaksi', 15, 2);
            $table->text('catatan_tindakan')->nullable();
            // $table->foreignId('pelaksana_id')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->timestamps();

            $table->unique(['kunjungan_id', 'tindakan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_tindakan');
    }
};