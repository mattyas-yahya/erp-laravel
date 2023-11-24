<?php

namespace App\Repositories\Production;

use Illuminate\Support\Facades\DB;

class ProductionScheduleDbQueryRepository
{
    public function reportPaginated(
        $filters,
        $perPage = 50
    )
    {
        $scheduleDetails = DB::table('production_schedule_details')
            ->select([
                'production_schedule_details.dimension_t',
                'production_schedule_details.dimension_l',
                'production_schedule_details.dimension_p',
                'production_schedule_details.pieces',
                'production_schedule_details.production_total',
                'production_schedule_details.pack',
                'production_schedule_details.description',
                'production_schedules.job_order_number',
                'production_schedules.production_date',
                'production_schedules.status',
                'customers.customer_id',
                'goods_receipt_details.sku_number',
                'goods_receipt_details.no_coil',
                'goods_receipt_details.product_name',
                'goods_receipt_details.dimensions',
                'machines.name AS machine_name',
                'product_service_units.name AS product_service_unit_name',
                'sales_orders.so_number',
                'sales_order_details.qty',
            ])
            ->join('production_schedules', 'production_schedule_details.production_schedule_id', '=', 'production_schedules.id')
            ->join('machines', 'production_schedules.machine_id', '=', 'machines.id')
            ->join('sales_order_details', 'production_schedules.sales_order_line_id', '=', 'sales_order_details.id')
            ->join('sales_orders', 'sales_order_details.so_id', '=', 'sales_orders.id')
            ->join('goods_receipt_details', 'sales_order_details.goods_receipt_details_id', '=', 'goods_receipt_details.id')
            ->join('product_service_units', 'goods_receipt_details.unit_id', '=', 'product_service_units.id')
            ->join('customers', 'production_schedules.customer_id', '=', 'customers.id')
            ->where('production_schedules.created_by', '=', \Auth::user()->creatorId());

        if ($filters['month'] !== '') {
            $scheduleDetails = $scheduleDetails->whereMonth('production_schedules.production_date', $filters['month']);
        }

        if ($filters['year'] !== '') {
            $scheduleDetails = $scheduleDetails->whereYear('production_schedules.production_date', $filters['year']);
        }

        return $scheduleDetails->paginate($perPage);
    }

    public function reportAll($filters)
    {
        $scheduleDetails = DB::table('production_schedule_details')
            ->select([
                'production_schedules.job_order_number',
                'sales_orders.so_number',
                'customers.customer_id',
                'production_schedules.production_date',
                'machines.name AS machine_name',
                'product_service_units.name AS product_service_unit_name',
                'production_schedules.status',
                'goods_receipt_details.sku_number',
                'sales_order_details.qty',
                'goods_receipt_details.no_coil',
                'goods_receipt_details.product_name',
                'goods_receipt_details.dimensions',
                'production_schedule_details.dimension_t',
                'production_schedule_details.dimension_l',
                'production_schedule_details.dimension_p',
                'production_schedule_details.pieces',
                'production_schedule_details.production_total',
                'production_schedule_details.pack',
                'production_schedule_details.description',
            ])
            ->join('production_schedules', 'production_schedule_details.production_schedule_id', '=', 'production_schedules.id')
            ->join('machines', 'production_schedules.machine_id', '=', 'machines.id')
            ->join('sales_order_details', 'production_schedules.sales_order_line_id', '=', 'sales_order_details.id')
            ->join('sales_orders', 'sales_order_details.so_id', '=', 'sales_orders.id')
            ->join('goods_receipt_details', 'sales_order_details.goods_receipt_details_id', '=', 'goods_receipt_details.id')
            ->join('product_service_units', 'goods_receipt_details.unit_id', '=', 'product_service_units.id')
            ->join('customers', 'production_schedules.customer_id', '=', 'customers.id')
            ->where('production_schedules.created_by', '=', \Auth::user()->creatorId());

        if (!empty($filters['month'])) {
            $scheduleDetails = $scheduleDetails->whereMonth('production_schedules.production_date', $filters['month']);
        }

        if (!empty($filters['year'])) {
            $scheduleDetails = $scheduleDetails->whereYear('production_schedules.production_date', $filters['year']);
        }

        return $scheduleDetails->get();
    }
}
