<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanRadiologi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'permintaan_radiologi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        'waktu_permintaan',
        'waktu_sampel',
        'waktu_hasil',
        'dokter_perujuk',
        'informasi_tambahan',
        'diganosis_klinis',
    ];

    public function detailPermintaan()
    {
        return $this->hasMany(DetailPermintaanRadiologi::class, 'id_permintaan_radiologi', 'id');
    }

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'no_rawat', 'no_rawat');
    }

    public function dokterPerujuk()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_perujuk', 'id');
    }
}
