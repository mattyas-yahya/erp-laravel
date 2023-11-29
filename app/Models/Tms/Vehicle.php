<?php

namespace App\Models\Tms;

use App\Models\Branch;
use App\Models\Vender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicles';

    protected $fillable = [
        'branch_id',
        'type',
        'hull_number',
        'license_plate',
        'owner_id',
        'image',
        'active',
        'inactive_reason',
    ];

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function owner()
    {
        return $this->hasOne(Vender::class, 'id', 'owner_id');
    }

    public function physical()
    {
        return $this->hasOne(VehiclePhysical::class, 'tms_vehicle_id', 'id');
    }

    public function document()
    {
        return $this->hasOne(VehicleDocument::class, 'tms_vehicle_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'tms_vehicle_id', 'id');
    }

    public function maintenances()
    {
        return $this->hasMany(VehicleMaintenance::class, 'tms_vehicle_id', 'id');
    }
}
