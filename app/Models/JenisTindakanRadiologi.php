<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisTindakanRadiologi extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama_perawatan',
        'total_tarif',
        'bhp',
        'kso',
        'manajemen',
        'bagian_rs',
        'tarif_perujuk',
        'tarif_dokter',
        'tarif_petugas',
    ];
    protected $table = 'jenis_tindakan_radiologi';

    protected $dates = ['deleted_at'];
}
