<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubJenisTindakanLab extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'sub_jenis_tindakan_lab';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_jenis_tindakan_lab',
        'sub_nama_pemeriksaan',
        'satuan',
        'nilai_rujukan',
    ];
    protected $dates = ['deleted_at'];
}
