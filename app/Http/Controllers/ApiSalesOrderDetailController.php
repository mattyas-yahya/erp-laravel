<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Marketing\SalesOrderService;

class ApiSalesOrderDetailController extends Controller
{
    private $salesOrderService;

    public function __construct(
        SalesOrderService $salesOrderService,
    ) {
        $this->salesOrderService = $salesOrderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($salesOrderDetailId)
    {
        return $this->salesOrderService->getSalesOrderDetail($salesOrderDetailId);
    }
}
