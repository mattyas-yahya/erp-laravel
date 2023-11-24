<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Eloquent\EloquentSetCreatedBy;

class PayrollDriverOvertime extends Model
{
    use HasFactory, EloquentSetCreatedBy;

    protected $fillable = [
        'rite',
        'overtime_pay_per_hour',
        'overtime_pay_total',
    ];
}
