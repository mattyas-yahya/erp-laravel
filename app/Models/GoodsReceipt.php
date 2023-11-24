<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function po()
    {
        return $this->hasOne('App\Models\PurchaseOrder', 'id', 'po_id');
    }

    public function vender()
    {
        return $this->hasOne('App\Models\Vender', 'id', 'vender_id');
    }

    public function cust()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customers_id');
    }
}
