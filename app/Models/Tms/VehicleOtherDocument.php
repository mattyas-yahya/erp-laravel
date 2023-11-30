<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleOtherDocument extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_detail_documents';

    protected $fillable = [
        'tms_vehicle_id',
        'name',
        'vendor',
        'planned_at',
        'planned_cost',
        'context_type',
        'status',
        'note',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(VehicleOtherDocumentDetail::class, 'tms_vehicle_detail_document_id', 'id');
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
            'DOCUMENT' => 'Document',
            'FINISHED' => 'Selesai',
        ];

        return Attribute::make(
            get: fn ($value, $attributes) => $texts[$attributes['status']]
        );
    }
}
