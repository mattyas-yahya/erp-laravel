<?php

namespace App\Models\Tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDocument extends Model
{
    use HasFactory;

    protected $table = 'tms_vehicle_documents';

    protected $fillable = [
        'tms_vehicle_id',
        'stnk_number',
        'stnk_owner_name',
        'stnk_validity_period',
        'stnk_owner_address',
        'bpkb_number',
        'last_kir_date',
    ];
}
