<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeriTindakanRalan extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_rawat',
        'dokter',
        'perawat',
        'nama_perawatan',
        'total_tarif',
        'bhp',
        'kso',
        'manajemen',
        'material',
        'tarif_dokter',
        'tarif_perawat',
        'waktu_pemberian',
    ];

    protected $table = 'beri_tindakan_ralan';
}
