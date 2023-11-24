<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany('App\Models\SalesOrderDetail', 'so_id', 'id');
    }

    public function cust()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function warehouse()
    {
        return $this->hasOne('App\Models\warehouse', 'id', 'warehouse_id');
    }

    public function employees()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }

    public function terms()
    {
        return $this->hasOne('App\Models\PaymentTerm', 'id', 'payment_term_id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'product_service_category_id');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'id', 'ref_number');
    }
}
