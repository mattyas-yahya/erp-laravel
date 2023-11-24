<?php

namespace App\Models\Tms;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'tms_assignments';

    protected $fillable = [
        'tms_vehicle_id',
        'delivery_order_number', // delivery waybill
        'driver_id',
        'started_at',
        'ended_at',
        'starting_odometer',
        'last_odometer',
        'comment',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id', 'tms_vehicle_id');
    }

    public function driver()
    {
        return $this->hasOne(Employee::class, 'id', 'driver_id');
    }

    public function details()
    {
        return $this->hasMany(AssignmentDetail::class, 'tms_assignment_id', 'id');
    }
}
