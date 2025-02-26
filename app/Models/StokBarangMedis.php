<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarangMedis extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'stok_barang_medis';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'depo',
        'databarang',
        'jumlah_stok',
    ];
}
