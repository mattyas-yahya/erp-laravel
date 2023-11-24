<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchaseOrderDetails()
    {
        return $this->hasMany('App\Models\PurchaseOrderDetail', 'po_id', 'id');
    }

    public function goodsReceipt()
    {
        return $this->hasOne('App\Models\GoodsReceipt', 'po_id', 'id');
    }

    public function vender()
    {
        return $this->hasOne('App\Models\Vender', 'id', 'vender_id');
    }

    public function warehouse()
    {
        return $this->hasOne('App\Models\warehouse', 'id', 'warehouse_id');
    }

    public function pr()
    {
        return $this->hasOne('App\Models\PurchaseRequest', 'id', 'pr_id');
    }

    public function terms()
    {
        return $this->hasOne('App\Models\PaymentTerm', 'id', 'payment_term_id');
    }

    public function getTotal()
    {
        return $this->hasMany('App\Models\PurchaseOrderDetail','po_id', 'id');
    }

    public function creator()
    {
        return $this->hasOne('App\Models\User','id', 'created_by');
    }

    public function bill()
    {
        return $this->belongsTo('App\Models\Bill', 'id', 'order_number');
    }
}
