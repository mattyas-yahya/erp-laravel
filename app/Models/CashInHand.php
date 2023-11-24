<?php

namespace App\Models;

use App\Domains\Accounting\PettyCash\CashInHandNominalValue;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashInHand extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_in_hand_number',
        'date',
        'initial_balance',
        'kasbon_balance',
        'account_balance',
        'information',
        'status',
    ];

    public function detail()
    {
        return $this->hasOne(CashInHandDetail::class);
    }

    public function getCashBalanceTotal() {
        $detail = $this->detail;

        if ($detail->count() === 0) {
            return 0;
        }

        $nominals = collect((new CashInHandNominalValue)->nominals);

        return $nominals->reduce(function (int $carry, int $value, string $key) use ($detail) {
            return $carry + ($value * $detail->$key);
        }, 0);
    }

    public function getBalanceTotal() {
        return $this->getCashBalanceTotal() + $this->account_balance - $this->kasbon_balance;
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
