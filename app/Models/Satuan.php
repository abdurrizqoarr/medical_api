<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    use HasFactory, SoftDeletes, HasUuids;  // Gunakan trait SoftDeletes

    protected $table = 'satuan';

    protected $fillable = ['satuan'];

    // Menentukan kolom yang akan digunakan sebagai primary key
    protected $primaryKey = 'id';

    // Menentukan tipe kolom id sebagai UUID
    public $incrementing = false;
    protected $keyType = 'string';

    // Menentukan kolom soft delete
    protected $dates = ['deleted_at'];
}
