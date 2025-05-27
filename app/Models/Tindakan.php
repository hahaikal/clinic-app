<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tindakan extends Model
{
    use HasFactory;

    protected $table = 'tindakan';

    protected $fillable = [
        'kode_tindakan',
        'nama_tindakan',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];
}
