<?php

namespace App\Repositories\Marketing;

use App\Models\SalesOrder;

class SalesOrderEloquentRepository
{
    public function all($filters = null)
    {
        $salesOrders = SalesOrder::where('created_by', '=', \Auth::user()->creatorId());

        if (!empty($filters->customer_id)) {
            $salesOrders = $salesOrders->where('customer_id', $filters->customer_id);
        }

        if (!empty($filters->employee_id)) {
            $salesOrders = $salesOrders->where('employee_id', $filters->employee_id);
        }

        return $salesOrders->get();
    }

    public function getDealSalesOrders($filters = null, $with = [])
    {
        $salesOrders = SalesOrder::where('created_by', '=', \Auth::user()->creatorId());

        if (!empty($with)) {
            $salesOrders = $salesOrders->with($with);
        }

        if (!empty($filters->customer_id)) {
            $salesOrders = $salesOrders->where('customer_id', $filters->customer_id);
        }

        if (!empty($filters->employee_id)) {
            $salesOrders = $salesOrders->where('employee_id', $filters->employee_id);
        }

        $salesOrders = $salesOrders->where('status', 'Deal');

        return $salesOrders->get();
    }

    public function getDoneSalesOrders($filters = null, $with = [])
    {
        $salesOrders = SalesOrder::where('created_by', '=', \Auth::user()->creatorId());

        if (!empty($with)) {
            $salesOrders = $salesOrders->with($with);
        }

        if (!empty($filters->customer_id)) {
            $salesOrders = $salesOrders->where('customer_id', $filters->customer_id);
        }

        if (!empty($filters->employee_id)) {
            $salesOrders = $salesOrders->where('employee_id', $filters->employee_id);
        }

        $salesOrders = $salesOrders->where('status', 'Done');

        return $salesOrders->get();
    }

    public function getDoesntHaveInvoiceSalesOrders($filters = null)
    {
        $salesOrders = SalesOrder::where('created_by', '=', \Auth::user()->creatorId());

        if (!empty($filters->customer_id)) {
            $salesOrders = $salesOrders->where('customer_id', $filters->customer_id);
        }

        if (!empty($filters->employee_id)) {
            $salesOrders = $salesOrders->where('employee_id', $filters->employee_id);
        }

        return $salesOrders->doesntHave('invoice')
            ->get();
    }

    public function cancelBooking()
    {
        return SalesOrder::where('status', 'Booking')
            ->where('exp_date_order', '<=', now()->toDateString())
            ->update(['status' => 'Cancel']);
    }
}
