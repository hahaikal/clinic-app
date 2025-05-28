<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'kunjungan_id',
        'no_tagihan',
        'tanggal_tagihan',
        'total_biaya_tindakan',
        'total_biaya_obat',
        'biaya_tambahan',
        'keterangan_biaya_tambahan',
        'diskon_persen',
        'diskon_nominal',
        'subtotal',
        'total_setelah_diskon',
        'grand_total',
        'jumlah_bayar',
        'kembalian',
        'metode_pembayaran',
        'nomor_referensi_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran_lunas',
        'kasir_id',
        'catatan_pembayaran',
    ];

    protected $casts = [
        'tanggal_tagihan' => 'datetime',
        'tanggal_pembayaran_lunas' => 'datetime',
        'total_biaya_tindakan' => 'decimal:2',
        'total_biaya_obat' => 'decimal:2',
        'biaya_tambahan' => 'decimal:2',
        'diskon_persen' => 'decimal:2',
        'diskon_nominal' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_setelah_diskon' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'jumlah_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id');
    }

    public function kasir()
    {
        return $this->belongsTo(Pegawai::class, 'kasir_id');
    }
}
