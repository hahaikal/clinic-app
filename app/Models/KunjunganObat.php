<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganObat extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_obat';

    protected $fillable = [
        'kunjungan_id',
        'obat_id',
        'jumlah_obat',
        'dosis',
        'aturan_pakai',
        'harga_jual_saat_transaksi',
        'catatan_resep',
    ];

    protected $casts = [
        'harga_jual_saat_transaksi' => 'decimal:2',
        'jumlah_obat' => 'integer',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}