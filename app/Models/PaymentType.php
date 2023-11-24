<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $fillable = [
        'name', 'chart_of_account_id', 'created_by'
    ];

    public function chartOfAccount()
    {
        return $this->hasOne(ChartOfAccount::class, 'id', 'chart_of_account_id');
    }
}
