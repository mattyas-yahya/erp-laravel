<?php

namespace App\Models;

use App\Models\Tms\AssignmentDetail as TmsAssignmentDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function salesOrder()
    {
        return $this->belongsTo('App\Models\SalesOrder', 'so_id', 'id');
    }

    public function gr_from_so()
    {
        return $this->hasOne('App\Models\GoodsReceiptDetail', 'id', 'goods_receipt_details_id');
    }

    public function productionSchedule()
    {
        return $this->hasOne('App\Models\ProductionSchedule', 'sales_order_line_id');
    }

    public function tmsAssignmentDetail()
    {
        return $this->hasOne(TmsAssignmentDetail::class, 'sales_order_detail_id');
    }
}
