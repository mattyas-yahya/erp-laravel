<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenanceDetail extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_maintenance_details';


    protected $fillable = [
        'tms_vehicle_maintenance_id',
        'name',
        'part_number',
        'category',
        'activity_type',
        'planned_quantity',
        'planned_cost',
        'planned_cost_total',
        'realized_quantity',
        'realized_cost',
        'realized_cost_total',
    ];
}
