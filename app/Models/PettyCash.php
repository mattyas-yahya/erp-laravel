<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;

    protected $fillable = [
        'petty_cash_number',
        'type',
        'received_by_type',
        'received_by',
        'received_by_employee_id',
        'date',
        'information',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(PettyCashDetail::class, 'petty_cash_id');
    }

    public function getTotal() {
        return $this->details()->sum('nominal');
    }

    protected function statusText(): Attribute
    {
        $texts = [
            'DRAFT' => 'Draft',
            'DONE' => 'Done',
        ];

        return Attribute::make(
            get: fn ($value, $attributes) => $texts[$attributes['status']]
        );
    }
}
