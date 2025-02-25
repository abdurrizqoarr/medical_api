<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenerimaanBarangMedis extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_penerimaan',
        'databarang',
        'jumlah',
        'harga_terima',
        'presentase_diskon',
        'total_harga_terima_sebelum_pajak',
        'presentase_pajak',
        'total_harga_pesan_setelah_pajak',
        'rek_pebayaran',
        'status'
    ];
    protected $table = 'detail_penerimaan_barang_medis';
}
