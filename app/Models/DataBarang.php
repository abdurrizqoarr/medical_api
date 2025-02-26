<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataBarang extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama_brng',
        'satuan',
        'isi',
        'kapasitas',
        'h_dasar',
        'h_beli',
        'harga_karyawan',
        'harga_jual',
        'harga_bebas',
        'jenis',
        'kategori',
        'golongan',
    ];
    protected $table = 'data_barang';

    protected $dates = ['deleted_at'];
}
