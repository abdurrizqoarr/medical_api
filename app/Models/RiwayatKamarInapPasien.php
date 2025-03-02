<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatKamarInapPasien extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'riwayat_kamar_inap_pasien';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        'id_bed',
        'tarif_harian',
        'tanggal_masuk',
        'tanggal_keluar',
        'tarif_total',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
