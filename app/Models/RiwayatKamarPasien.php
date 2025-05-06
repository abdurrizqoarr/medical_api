<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatKamarPasien extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'riwayat_kamar_pasien';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        "bed",
        "tarif_per_malam",
        "waktu_mulai",
        "waktu_selesai",
        "lama_inap",
        "tarif_total_inap",
        "status",
    ];
}
