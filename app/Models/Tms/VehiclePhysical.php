<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclePhysical extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_physicals';

    protected $fillable = [
        'tms_vehicle_id',
        'model',
        'chassis_number',
        'engine_number',
        'color',
        'imei_number',
        'fuel_capacity',
        'fuel_usage_ratio',
        'internal',
        'vehicle_owner',
        'manufacturer_year',
        'start_operation_date',
        'spare_tire_capacity',
        'kilometer_setting',
        'daily_travel_distance',
        'gps_gsm_number',
    ];
}
