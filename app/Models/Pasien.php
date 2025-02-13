<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $primaryKey = 'no_rm';
    public $incrementing = false; // Diubah menjadi true karena menggunakan bigIncrements
    protected $keyType = 'string'; // Diubah menjadi integer karena menggunakan bigIncrements
    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'no_ktp',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_ibu',
        'alamat',
        'gol_darah',
        'pekerjaan',
        'stts_nikah',
        'agama',
        'tgl_daftar',
        'no_tlp',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'suku',
        'bahasa',
        'provinsi',
        'cacat_fisik',
        'pendidikan',
        'keluarga',
    ];
}
