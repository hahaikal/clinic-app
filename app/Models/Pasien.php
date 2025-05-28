<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_lengkap',
        'wilayah_id',
        'telepon',
        'pekerjaan',
        'agama',
        'status_pernikahan',
        'golongan_darah',
        'alergi_obat',
        'nama_penanggung_jawab',
        'telepon_penanggung_jawab',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'pasien_id');
    }
}
