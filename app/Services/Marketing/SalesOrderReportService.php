<?php

namespace App\Services\Marketing;

use Illuminate\Support\Facades\Auth;
use App\Domains\Marketing\SalesOrderStatusValue;
use App\Models\SalesOrderDetail;

class SalesOrderReportService
{
    public function getSalesOrderDetails()
    {
        // TODO: separate into repository
        return SalesOrderDetail::with('gr_from_so')
            ->where('created_by', Auth::user()->creatorId())
            ->get();
    }

    public function getNonProcessedSalesOrderDetails()
    {
        // TODO: separate into repository
        $salesOrderDetails = SalesOrderDetail::with(['gr_from_so'])
            ->whereHas('salesOrder', function ($query) {
                $query->whereNotIn('status', [
                    SalesOrderStatusValue::STATUS_PRODUCTION,
                    SalesOrderStatusValue::STATUS_DELIVERY,
                    SalesOrderStatusValue::STATUS_DONE
                ]);
            })
            ->where('created_by', Auth::user()->creatorId())
            ->get();

        return $salesOrderDetails;
    }

    public function getStatuses()
    {
        return [
            SalesOrderStatusValue::STATUS_BOOKING,
            SalesOrderStatusValue::STATUS_DEAL,
            SalesOrderStatusValue::STATUS_PRODUCTION,
            SalesOrderStatusValue::STATUS_DELIVERY,
            SalesOrderStatusValue::STATUS_DONE
        ];
    }
}
