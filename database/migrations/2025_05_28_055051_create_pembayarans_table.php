<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->unique()->constrained('kunjungan')->onDelete('cascade');
            $table->string('no_tagihan')->unique()->comment('Nomor unik untuk tagihan/invoice');
            $table->dateTime('tanggal_tagihan')->useCurrent();

            $table->decimal('total_biaya_tindakan', 15, 2)->default(0);
            $table->decimal('total_biaya_obat', 15, 2)->default(0);
            $table->decimal('biaya_tambahan', 15, 2)->nullable()->default(0);
            $table->string('keterangan_biaya_tambahan')->nullable();
            $table->decimal('diskon_persen', 5, 2)->nullable()->default(0)->comment('Diskon dalam persen, misal 10.00 untuk 10%');
            $table->decimal('diskon_nominal', 15, 2)->nullable()->default(0)->comment('Diskon dalam nominal Rupiah');
            $table->decimal('subtotal', 15, 2)->comment('Total tindakan + obat + biaya tambahan');
            $table->decimal('total_setelah_diskon', 15, 2)->comment('Subtotal - diskon');
            $table->decimal('grand_total', 15, 2)->comment('Jumlah akhir yang harus dibayar');

            $table->decimal('jumlah_bayar', 15, 2)->nullable();
            $table->decimal('kembalian', 15, 2)->nullable();
            $table->string('metode_pembayaran', 50)->nullable();
            $table->string('nomor_referensi_pembayaran')->nullable()->comment('No. Kartu, No. Transaksi, No. Polis Asuransi');
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas', 'Sebagian Dibayar', 'Dibatalkan'])->default('Belum Lunas');
            $table->dateTime('tanggal_pembayaran_lunas')->nullable();

            $table->foreignId('kasir_id')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->text('catatan_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};