<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeRanap extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'resume_ranap';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        'dokter_dpjb',
        'tanggal_masuk',
        'tanggal_keluar',
        'waktu_resume',
        'status_pulang',
        'keluhan_utama',
        'jalannya_penyakit_selama_perawatan',
        'pemeriksaan_radiologi',
        'pemeriksaan_laboratorium',
        'tindakan_operasi',
        'riwayat_obat',
        'riwayat_diet',
        'obat_pulang',
        'catatan',
        'diagnosa_utama',
        'diagnosa_sekunder',
        'prosedur_utama',
        'prosedur_sekunder',
    ];
}
