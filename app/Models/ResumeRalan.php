<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeRalan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'resume_ralan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        'dokter_dpjb',
        'waktu_resume',
        'status_pulang',
        'keluhan_utama',
        'jalannya_penyakit_selama_perawatan',
        'pemeriksaan_radiologi',
        'pemeriksaan_laboratorium',
        'riwayat_obat',
        'catatan',
        'diagnosa_utama',
        'diagnosa_sekunder',
        'prosedur_utama',
        'prosedur_sekunder',
    ];
}
