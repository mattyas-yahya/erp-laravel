<?php

namespace App\Models\Tms;

use App\Models\Customer;
use App\Models\SalesOrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentDetail extends Model
{
    use HasFactory;

    protected $table = 'tms_assignment_details';

    protected $fillable = [
        'tms_assignment_id',
        'customer_id',
        'sales_order_detail_id',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'tms_assignment_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function salesOrderDetail()
    {
        return $this->belongsTo(SalesOrderDetail::class, 'sales_order_detail_id');
    }
}
