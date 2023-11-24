<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequisition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function purchase_request_head()
    {
        return $this->hasMany('App\Models\PurchaseRequest', 'id', 'pr_id')->first();
    }

    public function unit()
    {
        return $this->hasMany('App\Models\ProductServiceUnit', 'id', 'unit_id')->first();
    }

    public function productservices()
    {
        return $this->hasMany('App\Models\ProductService', 'id', 'product_services_id')->first();
    }
}
