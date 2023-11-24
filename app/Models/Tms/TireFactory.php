<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireFactory extends Model
{
    use HasFactory;

    protected $table = 'tms_tire_factories';

    protected $fillable = [
        'name',
    ];
}
