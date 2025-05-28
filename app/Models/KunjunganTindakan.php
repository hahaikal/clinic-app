<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KunjunganTindakan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_tindakan';

    protected $fillable = [
        'kunjungan_id',
        'tindakan_id',
        'jumlah',
        'harga_saat_transaksi',
        'catatan_tindakan',
        // 'pelaksana_id',
    ];

    protected $casts = [
        'harga_saat_transaksi' => 'decimal:2',
        'jumlah' => 'integer',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class);
    }

    // public function pelaksana()
    // {
    //     return $this->belongsTo(Pegawai::class, 'pelaksana_id');
    // }
}
