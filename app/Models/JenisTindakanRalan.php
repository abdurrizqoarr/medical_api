<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisTindakanRalan extends Model
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
        'material',
        'tarif_dokter',
        'tarif_perawat',
    ];
    protected $table = 'jenis_tindakan_ralan';

    protected $dates = ['deleted_at'];
}
