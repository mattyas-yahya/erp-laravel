<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domains\Tax\TaxValue;
use App\Services\Marketing\SalesOrderService;

class SalesOrderHistoryController extends Controller
{
    private $salesOrderService;

    public function __construct(
        SalesOrderService $salesOrderService,
    ) {
        $this->salesOrderService = $salesOrderService;
    }

    function index(Request $request)
    {
        if (!Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $taxValues = TaxValue::get();
        $allSalesOrderDetails = $this->salesOrderService->getSalesOrderDetails([]);
        $salesOrderDetails = $this->salesOrderService->getSalesOrderDetails($request->all());

        $filterValues = [
            'sales_orders' => $allSalesOrderDetails
                ->map(function ($item) { return $item->so_number; })
                ->unique()
                ->sort()
                ->values()
                ->mapWithKeys(function ($item, $key) {
                    return [$item => $item];
                })
                ->prepend(__('All'), '')
                ->all(),
            'coil_numbers' => $allSalesOrderDetails->map(function ($item) { return $item->no_coil; })
                ->unique()
                ->sort()
                ->values()
                ->mapWithKeys(function ($item, $key) {
                    return [$item => $item];
                })
                ->prepend(__('All'), '')
                ->all(),
            'id_sjb' => $allSalesOrderDetails->map(function ($item) { return $item->gr_from_so?->sku_number; })
                ->unique()
                ->sort()
                ->values()
                ->mapWithKeys(function ($item, $key) {
                    return [$item => $item];
                })
                ->prepend(__('All'), '')
                ->all(),
        ];

        return view('marketing.history.index', [
            'filterValues' => $filterValues,
            'taxValues' => $taxValues,
            'salesOrderDetails' => $salesOrderDetails,
        ]);
    }
}
