<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Marketing\SalesOrderService;

class ApiSalesOrderController extends Controller
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
    public function index(Request $request)
    {
        return $this->salesOrderService->getDoesntHaveInvoiceSalesOrders($request);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, string $salesOrderId)
    {
        return $this->salesOrderService->getSalesOrderDetails($request->all(), $salesOrderId);
    }
}
