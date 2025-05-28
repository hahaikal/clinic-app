<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';

    protected $fillable = [
        'pasien_id',
        'no_kunjungan',
        'tanggal_kunjungan',
        'jenis_kunjungan',
        'keluhan_utama',
        'tinggi_badan_cm',
        'berat_badan_kg',
        'suhu_badan_celsius',
        'sistole_mmhg',
        'diastole_mmhg',
        'frekuensi_nadi_per_menit',
        'frekuensi_nafas_per_menit',
        'pegawai_id_pendaftar',
        'dokter_id',
        'status_kunjungan',
        'anamnesis',
        'catatan_tambahan_pendaftaran',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'datetime',
        'berat_badan_kg' => 'decimal:2',
        'suhu_badan_celsius' => 'decimal:1',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function pendaftar()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id_pendaftar');
    }

    public function dokter()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_id');
    }

    public function daftarTindakan()
    {
        return $this->hasMany(KunjunganTindakan::class);
    }

    public function daftarObat()
    {
        return $this->hasMany(KunjunganObat::class);
    }
}
