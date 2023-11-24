<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productService()
    {
        return $this->belongsTo('App\Models\ProductService', 'product_services_id', 'id');
    }

    public function productServiceUnit()
    {
        return $this->hasOne('App\Models\ProductServiceUnit', 'id', 'unit_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_service_id')->first();
    }

    public function purchase_order_head()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'id', 'po_id')->first();
    }

    public function pr()
    {
        return $this->hasOne('App\Models\PurchaseRequest', 'id', 'pr_id');
    }

    public function unit()
    {
        return $this->hasMany('App\Models\ProductServiceUnit', 'id', 'unit_id')->first();
    }

    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function goodsReceiptDetail()
    {
        return $this->hasOne('App\Models\GoodsReceiptDetail', 'purchase_order_detail_id', 'id');
    }

}
