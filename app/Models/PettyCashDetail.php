<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'cash_payment_id',
        'payment_type',
        'license_plate',
        'information',
        'nominal',
    ];

    public function cashPayment()
    {
        return $this->belongsTo(PettyCash::class, 'cash_payment_id');
    }
}
