<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarangMedis extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penerimaan_barang_medis';
    protected $primaryKey = 'no_penerimaan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_penerimaan',
        'no_pegajuan',
        'supplier',
        'depo_penerima',
        'pegawai_penerima',
        'tanggal_penerimaan',
        'tanggal_jatuh_tempo',
        'total_sebelum_pajak',
        'total_setelah_pajak',
        'rek_pebayaran',
    ];
}
