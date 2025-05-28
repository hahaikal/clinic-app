<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungan')->onDelete('cascade');
            $table->foreignId('obat_id')->constrained('obat')->onDelete('restrict');
            $table->integer('jumlah_obat');
            $table->string('dosis')->nullable();
            $table->string('aturan_pakai')->nullable();
            $table->decimal('harga_jual_saat_transaksi', 15, 2);
            $table->text('catatan_resep')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_obat');
    }
};
