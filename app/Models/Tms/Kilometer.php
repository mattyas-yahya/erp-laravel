<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kilometer extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_kilometers';

    protected $fillable = [
        'tms_vehicle_id',
        'travel_date',
        'travel_kilometers',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id', 'tms_vehicle_id');
    }
}
