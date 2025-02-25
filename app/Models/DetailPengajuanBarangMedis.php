<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengajuanBarangMedis extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'detail_pengajuan_barang_medis';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_pegajuan',
        'databarang',
        'jumlah',
        'harga_pesan',
        'total_harga_pesan_sebelum_pajak',
        'presentase_pajak',
        'total_harga_pesan_setelah_pajak'
    ];
}
