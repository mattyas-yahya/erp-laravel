<?php

namespace App\Repositories\Production;

use Illuminate\Support\Facades\DB;
use App\Domains\Helpers\ModelHelper;
use App\Domains\Production\ProductionStatusValue;
use App\Models\ProductionSchedule;
use App\Models\SalesOrderDetail;
use App\Models\GoodsReceiptDetail;

class ProductionScheduleEloquentRepository
{
    public function all(
        $filters
    )
    {
        $schedules = ProductionSchedule::with(['customer', 'machine', 'salesOrderLine.gr_from_so'])
            ->withSum('details', 'production_total')
            ->where('created_by', '=', \Auth::user()->creatorId());

        if ($filters['month'] !== '') {
            $schedules = $schedules->whereMonth('production_date', $filters['month']);
        }

        if ($filters['year'] !== '') {
            $schedules = $schedules->whereYear('production_date', $filters['year']);
        }

        if (!empty($filters['ids'])) {
            $schedules = $schedules->whereIn('id', $filters['ids']);
        }

        return $schedules->get();
    }

    public function find($id)
    {
        $schedule = ProductionSchedule::with(['machine', 'salesOrderLine'])
            ->withSum('details', 'production_total')
            ->find($id);

        return $schedule;
    }

    public function create($request)
    {
        $nextId = $request?->is_raw_material != true
                    ? ModelHelper::getLastId(ProductionSchedule::class, 'id')
                    : null;

        ProductionSchedule::where('sales_order_line_id', $request->sales_order_line_id)
            ->update([
                'production_status' => ProductionStatusValue::STATUS_CANCELED
            ]);

        $salesOrderDetail = SalesOrderDetail::find($request->sales_order_line_id);
        $goodsReceiptDetail = GoodsReceiptDetail::find($salesOrderDetail->goods_receipt_details_id);

        return ProductionSchedule::create([
            'job_order_number' => ($nextId ? 'JO-' . sprintf('%03d', $nextId) : null),
            'sales_order_line_id' => $request->sales_order_line_id,
            'customer_id' => $request->customer_id,
            'production_date' => $request->production_date,
            'machine_id' => $request->machine_id,
            'product_name' => $goodsReceiptDetail->product_name,
            'status' => $salesOrderDetail->production,
        ]);
    }

    public function update($request, $id)
    {
        $schedule = ProductionSchedule::findOrFail($id);

        $schedule->fill($request->all());
        $schedule->save();

        return $schedule;
    }

    public function delete(string $id)
    {
        $deleted = 0;
        $schedule = ProductionSchedule::find($id);

        DB::transaction(function () use (&$deleted, $schedule) {
            $schedule->salesOrderLine()->update([
                'production_status' => ProductionStatusValue::STATUS_CANCELED
            ]);
            $schedule->details()->delete();
            $deleted = $schedule->delete();
        });

        return $deleted;
    }

    public function setProductionProcessed($id)
    {
        $productionSchedule = ProductionSchedule::find($id);
        $productionSchedule->production_status = ProductionStatusValue::STATUS_PROCESSED;

        $productionSchedule->salesOrderLine()->update([
            'production_status' => ProductionStatusValue::STATUS_PROCESSED
        ]);

        return $productionSchedule->save();
    }

    public function setProductionFinished($id)
    {
        $productionSchedule = ProductionSchedule::find($id);
        $productionSchedule->production_status = ProductionStatusValue::STATUS_FINISHED;

        $productionSchedule->salesOrderLine()->update([
            'production_status' => ProductionStatusValue::STATUS_FINISHED
        ]);

        return $productionSchedule->save();
    }
}
