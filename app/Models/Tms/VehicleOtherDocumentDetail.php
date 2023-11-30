<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOtherDocumentDetail extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_detail_document_details';

    protected $fillable = [
        'tms_vehicle_detail_document_id',
        'name',
        'category',
        'activity_type',
        'quantity',
        'price',
    ];
}
