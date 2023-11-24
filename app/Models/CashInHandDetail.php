<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashInHandDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_in_hand_id',
        'one_hundred_thousand_notes',
        'seventy_five_thousand_notes',
        'fifty_thousand_notes',
        'twenty_thousand_notes',
        'ten_thousand_notes',
        'five_thousand_notes',
        'two_thousand_notes',
        'one_thousand_notes',
        'five_hundred_notes',
        'two_hundred_notes',
        'one_hundred_notes',
    ];

    public function cashInHand()
    {
        return $this->belongsTo(CashInHand::class);
    }
}
