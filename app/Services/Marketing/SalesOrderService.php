<?php

namespace App\Services\Marketing;

use App\Domains\Caches\SalesOrderCacheConst;
use App\Domains\Marketing\SalesOrderDeliveryValue;
use App\Domains\Marketing\SalesOrderStatusValue;
use App\Repositories\Marketing\SalesOrderEloquentRepository;
use App\Repositories\Marketing\SalesOrderDetailEloquentRepository;
use Carbon\Carbon;

class SalesOrderService
{
    protected $salesOrderRepo;
    protected $salesOrderDetailRepo;

    public function __construct(
        SalesOrderEloquentRepository $salesOrderRepo,
        SalesOrderDetailEloquentRepository $salesOrderDetailRepo
    ) {
        $this->salesOrderRepo = $salesOrderRepo;
        $this->salesOrderDetailRepo = $salesOrderDetailRepo;
    }

    public function getSalesOrders($filters)
    {
        return $this->salesOrderRepo->all($filters);
    }

    public function getDealSalesOrders($filters)
    {
        return $this->salesOrderRepo->getDealSalesOrders($filters, ['cust']);
    }

    public function getDoneSalesOrders($filters)
    {
        return $this->salesOrderRepo->getDoneSalesOrders($filters, ['cust']);
    }

    public function getDoesntHaveInvoiceSalesOrders()
    {
        return $this->salesOrderRepo->getDoesntHaveInvoiceSalesOrders();
    }

    public function getSalesOrderDetails($filters = [], $salesOrderId = null)
    {
        $details = $this->salesOrderDetailRepo->all((object) [
            ...$filters,
            'sales_order_id' => $salesOrderId,
        ]);

        $details = $details->map(function ($item) {
            $item->total = 0;

            if ($item?->gr_from_so?->unit()->name === 'Kg') {
                $item->total = ($item->sale_price * $item?->gr_from_so?->weight) - $item->discount;
            } elseif ($item?->gr_from_so?->unit()->name === 'Pcs') {
                $item->total = ($item->sale_price * $item->qty) - $item->discount;
            } else {
                $item->total = ($item->sale_price * $item->qty) - $item->discount;
            }

            return $item;
        });

        return $details;
    }

    public function getUnprocessedSalesOrderDetails()
    {
        return $this->salesOrderDetailRepo->getUnprocessed();
    }

    public function getFinishedSalesOrderDetails()
    {
        return $this->salesOrderDetailRepo->getFinished();
    }

    public function getTmsUnassignedSalesOrderDetails()
    {
        return $this->salesOrderDetailRepo->getDoesntHaveTmsAssignmentSalesOrders();
    }

    public function getSalesOrderDetail($salesOrderDetailId = null)
    {
        $detail = $this->salesOrderDetailRepo->find($salesOrderDetailId);

        return $detail;
    }

    // TODO: refactor
    public function getSalesOrderDetailCustomers($salesOrderDetails)
    {
        $customers = collect([]);
        foreach ($salesOrderDetails as $detail) {
            $customers->push((object) [
                'sales_order_detail_id' => $detail->id,
                'customer_id' => $detail->salesOrder->customer_id,
                'formatted_customer_id' => \Auth::user()->customerNumberFormat($detail->salesOrder->customer_id),
            ]);
        }

        return $customers;
    }

    // TODO: refactor
    public function getSalesOrderDetailGoodsDetail($salesOrderDetails)
    {
        $goodsDetails = collect([]);
        foreach ($salesOrderDetails as $detail) {
            $goodsDetails->push((object) [
                'sales_order_detail_id' => $detail->id,
                'dimensions' => $detail?->gr_from_so?->dimensions,
                'no_coil' => $detail?->gr_from_so?->no_coil,
                'weight' => $detail?->gr_from_so?->weight,
            ]);
        }

        return $goodsDetails;
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

    public function getDeliveryValues()
    {
        return [
            SalesOrderDeliveryValue::DELIVERY_FRANCO,
            SalesOrderDeliveryValue::DELIVERY_LOCO,
        ];
    }

    public function updateExpiredBookingStatus()
    {
        if (!\Cache::has(SalesOrderCacheConst::BOOKING_CANCELED_AT)) {
            \Cache::add(SalesOrderCacheConst::BOOKING_CANCELED_AT, now()->subDay()->toDateString());
        }

        $statusLastUpdatedAt = Carbon::createFromFormat('Y-m-d', \Cache::get(SalesOrderCacheConst::BOOKING_CANCELED_AT));

        if (!$statusLastUpdatedAt->isSameDay(now())) {
            \Cache::put(SalesOrderCacheConst::BOOKING_CANCELED_AT, now()->toDateString());

            return $this->salesOrderRepo->cancelBooking();
        }

        return false;
    }
}
