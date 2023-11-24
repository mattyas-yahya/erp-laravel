<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_plat',
        'merek_mobil',
        'latitude',
        'longtitude',
        'imei',
    ];
}
