<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleFile extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_files';

    protected $fillable = [
        'tms_vehicle_id',
        'file',
        'name',
        'type',
        'expired_at',
        'remaining_time',
        'active',
    ];
}
