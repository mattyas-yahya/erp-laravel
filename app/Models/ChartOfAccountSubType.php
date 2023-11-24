<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccountSubType extends Model
{
    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

    public function coa_type()
    {
        return $this->hasOne('App\Models\ChartOfAccountType','id','type');
    }
}
