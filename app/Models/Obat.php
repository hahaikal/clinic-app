<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'satuan',
        'harga_jual',
        'stok',
    ];

    protected $casts = [
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
    ];

    public function detailKunjunganObat()
    {
        return $this->hasMany(KunjunganObat::class);
    }
}
