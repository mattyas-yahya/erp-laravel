<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Eloquent\EloquentSetCreatedBy;

class Machine extends Model
{
    use HasFactory, EloquentSetCreatedBy;

    protected $fillable = [
        'name',
        'created_by',
    ];

    public function productionSchedules()
    {
        return $this->hasMany(ProductionSchedule::class, 'machine_id');
    }
}
