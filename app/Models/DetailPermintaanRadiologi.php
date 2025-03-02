<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPermintaanRadiologi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'detail_permintaan_radiologi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_permintaan_radiologi',
        'id_jenis_tindakan_radiologi',
        'status',
    ];

    public function permintaanRadiologi()
    {
        return $this->belongsTo(PermintaanRadiologi::class, 'id_permintaan_radiologi', 'id');
    }

    /**
     * Relasi ke JenisTindakanRadiologi
     */
    public function jenisTindakanRadiologi()
    {
        return $this->belongsTo(JenisTindakanRadiologi::class, 'id_jenis_tindakan_radiologi', 'id');
    }
}
