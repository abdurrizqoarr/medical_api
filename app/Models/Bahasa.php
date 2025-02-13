<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahasa extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'bahasa';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['bahasa'];

    protected $dates = ['deleted_at'];
}
