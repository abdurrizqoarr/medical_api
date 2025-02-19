<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanKamarInap extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pemeriksaan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        'petugas_pemohon',
        'petugas_penerima',
        'bed',
        'diagnosa_awal',
        'waktu_permintaan',
        'bed_akhir',
    ];
}
