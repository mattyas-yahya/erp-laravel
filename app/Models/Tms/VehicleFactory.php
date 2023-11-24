<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleFactory extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_factories';

    protected $fillable = [
        'name',
    ];
}
