<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarangMedis extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_barang_medis';
    protected $primaryKey = 'no_pegajuan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_pegajuan',
        'supplier',
        'pegawai_pengaju',
        'tanggal_pengajuan',
        'total_sebelum_pajak',
        'total_setelah_pajak',
        'status'
    ];
}
