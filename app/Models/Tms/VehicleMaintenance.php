<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_maintenances';

    protected $fillable = [
        'tms_vehicle_id',
        'name',
        'context_type',
        'date',
        'vendor',
        'planned_at',
        'planned_kilometers',
        'planned_cost',
        'realized_at',
        'realized_kilometers',
        'realized_cost',
        'status',
        'note',
    ];

    public function details()
    {
        return $this->hasMany(VehicleMaintenanceDetail::class, 'tms_vehicle_maintenance_detail_id', 'id');
    }

    protected function contextTypeText(): Attribute
    {
        $texts = [
            'INTERNAL' => 'Internal',
            'EKSTERNAL' => 'Eksternal',
        ];

        return Attribute::make(
            get: fn ($value, $attributes) => $texts[$attributes['context_type']]
        );
    }

    protected function statusText(): Attribute
    {
        $texts = [
            'SUBMISSION' => 'Pengajuan',
            'PLAN' => 'Rencana',
            'MAINTENANCE' => 'Perawatan',
            'FINISHED' => 'Selesai',
        ];

        return Attribute::make(
            get: fn ($value, $attributes) => $texts[$attributes['status']]
        );
    }
}
