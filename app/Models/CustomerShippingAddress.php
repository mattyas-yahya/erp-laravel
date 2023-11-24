<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerShippingAddress extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'customer_id',
        'name',
        'country',
        'state',
        'city',
        'phone',
        'zip',
        'address',
    ];
}
