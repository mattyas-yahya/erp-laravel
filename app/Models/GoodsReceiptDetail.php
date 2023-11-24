<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GoodsReceiptDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'gr_id',
        'po_id',
        'purchase_order_detail_id',
        'gr_number',
        'no_kontrak',
        'sku_number',
        'product_name',
        'qty',
        'unit_id',
        'dimensions',
        'manufacture',
        'weight',
        'tax_id',
        'tax_ppn',
        'tax_pph',
        'discount',
        'price',
        'price_include',
        'description',
        'approval',
        'created_by',
    ];

    protected $guarded = [];

    public function gr()
    {
        return $this->hasOne('App\Models\GoodsReceipt', 'id', 'gr_id');
    }

    public function productServiceUnit()
    {
        return $this->hasOne('App\Models\ProductServiceUnit', 'id', 'unit_id');
    }

    public function unit()
    {
        return $this->hasMany('App\Models\ProductServiceUnit', 'id', 'unit_id')->first();
    }

    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function po()
    {
        return $this->hasOne('App\Models\PurchaseOrder', 'id', 'po_id');
    }

    public function purchaseOrderDetail()
    {
        return $this->hasOne('App\Models\PurchaseOrderDetail', 'id', 'purchase_order_detail_id');
    }

    public function goodsAge()
    {
        $date = Carbon::parse($this?->gr?->date_goodscome);
        $now = Carbon::now();

        return $date->diffInDays($now);
    }
}
