<?php

namespace App\Repositories\Marketing;

use App\Domains\Production\ProductionStatusValue;
use App\Models\SalesOrderDetail;

class SalesOrderDetailEloquentRepository
{
    public function all($filters = null)
    {
        $salesOrderDetails = SalesOrderDetail::with('gr_from_so.productServiceUnit')
            ->where('created_by', \Auth::user()->creatorId());

        if (!empty($filters->sales_order_id)) {
            $salesOrderDetails = $salesOrderDetails->where('so_id', $filters->sales_order_id);
        }

        if (!empty($filters->sales_order_ids)) {
            $salesOrderDetails = $salesOrderDetails->whereIn('so_id', $filters->sales_order_ids);
        }

        if (!empty($filters->so_number)) {
            $salesOrderDetails = $salesOrderDetails->where('so_number', $filters->so_number);
        }

        if (!empty($filters->no_coil)) {
            $salesOrderDetails = $salesOrderDetails->where('no_coil', $filters->no_coil);
        }

        if (!empty($filters->sku_number)) {
            $salesOrderDetails = $salesOrderDetails->whereHas('gr_from_so', function ($query) use ($filters) {
                $query->where('sku_number', $filters->sku_number);
            });
        }

        return $salesOrderDetails->get();
    }

    public function find($id)
    {
        $salesOrderDetail = SalesOrderDetail::with('gr_from_so.productServiceUnit')
            ->where('created_by', \Auth::user()->creatorId())
            ->where('id', $id);

        return $salesOrderDetail->get();
    }

    public function getUnprocessed()
    {
        return SalesOrderDetail::with([
            'salesOrder',
            'gr_from_so'
        ])
            ->whereNotIn('production_status', [
                ProductionStatusValue::STATUS_PROCESSED,
                ProductionStatusValue::STATUS_FINISHED,
            ])
            ->where('created_by', \Auth::user()->creatorId())
            ->get();
    }

    public function getFinished()
    {
        return SalesOrderDetail::with([
            'salesOrder',
            'gr_from_so',
            'productionSchedule'
        ])
            ->whereHas('productionSchedule')
            ->whereIn('production_status', [
                ProductionStatusValue::STATUS_FINISHED,
            ])
            ->where('created_by', \Auth::user()->creatorId())
            ->get();
    }

    public function getDoesntHaveTmsAssignmentSalesOrders($filters = null)
    {
        $salesOrders = SalesOrderDetail::where('created_by', '=', \Auth::user()->creatorId());

        return $salesOrders->doesntHave('tmsAssignmentDetail')
            ->get();
    }

    public function setProductionScheduled($id)
    {
        $salesOrderDetail = SalesOrderDetail::find($id);
        $salesOrderDetail->production_status = ProductionStatusValue::STATUS_SCHEDULED;

        return $salesOrderDetail->save();
    }

    public function setProductionProcessed($id)
    {
        $salesOrderDetail = SalesOrderDetail::find($id);
        $salesOrderDetail->production_status = ProductionStatusValue::STATUS_PROCESSED;

        return $salesOrderDetail->save();
    }

    public function setProductionFinished($id)
    {
        $salesOrderDetail = SalesOrderDetail::find($id);
        $salesOrderDetail->production_status = ProductionStatusValue::STATUS_FINISHED;

        return $salesOrderDetail->save();
    }

    public function setProductionCanceled($id)
    {
        $salesOrderDetail = SalesOrderDetail::find($id);
        $salesOrderDetail->production_status = ProductionStatusValue::STATUS_CANCELED;

        return $salesOrderDetail->save();
    }
}
