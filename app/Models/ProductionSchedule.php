<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Eloquent\EloquentSetCreatedBy;

class ProductionSchedule extends Model
{
    use HasFactory, EloquentSetCreatedBy;

    protected $fillable = [
        'job_order_number',
        'sales_order_line_id',
        'customer_id',
        'production_date',
        'machine_id',
        'product_name',
        'status',
        'production_status',
        'created_by',
    ];

    public function details()
    {
        return $this->hasMany(ProductionScheduleDetail::class, 'production_schedule_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

    public function salesOrderLine()
    {
        return $this->hasOne(SalesOrderDetail::class, 'id', 'sales_order_line_id');
    }
}
