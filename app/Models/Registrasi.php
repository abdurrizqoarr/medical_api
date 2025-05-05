<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'registrasi';
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        'waktu_registrasi',
        'antrian_poli',
        'status_periksa',
        'status_rawat',
        'jaminan',
        'status_bayar',
        'poli',
        'dokter',
        'pasien',
    ];

    public function pasienData()
    {
        return $this->belongsTo(Pasien::class, 'pasien', 'no_rm');
    }

    public function poliData()
    {
        return $this->belongsTo(Poli::class, 'poli', 'id');
    }

    public function dokterData()
    {
        return $this->belongsTo(Dokter::class, 'dokter', 'id');
    }

    public function jaminanData()
    {
        return $this->belongsTo(Jaminan::class, 'jaminan', 'id');
    }
}
