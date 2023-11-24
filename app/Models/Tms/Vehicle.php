<?php

namespace App\Models\Tms;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicles';

    protected $fillable = [
        'branch_id',
        'hull_number',
        'license_plate',
        'image',
        'active',
        'inactive_reason',
    ];

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function physical()
    {
        return $this->hasOne(VehiclePhysical::class, 'tms_vehicle_id', 'id');
    }

    public function document()
    {
        return $this->hasOne(VehicleDocument::class, 'tms_vehicle_id', 'id');
    }
}
