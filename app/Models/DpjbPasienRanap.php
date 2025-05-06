<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpjbPasienRanap extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'dpjb_pasien_ranap';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_rawat',
        'dokter_dpjb',
        'dpjb_utama'
    ];
}
