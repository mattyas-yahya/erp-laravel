<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Domains\Helpers\DateHelper;
use App\Models\Employee;
use App\Services\Marketing\SalesOrderService;

class DashboardMarketingController extends Controller
{
    private $salesOrderService;

    public function __construct(
        SalesOrderService $salesOrderService,
    ) {
        $this->salesOrderService = $salesOrderService;
    }

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage sales order')) {
        // return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $marketingEmployees = Employee::whereRelation('designation', 'name', 'LIKE', '%' . 'Marketing' . '%')
            ->where('created_by', '=', Auth::user()->creatorId())
            ->get();

        $salesOrders = $this->salesOrderService->getDoneSalesOrders($request);
        $salesOrderDetails = $this->salesOrderService->getSalesOrderDetails([
            'sales_order_ids' => $salesOrders->pluck('id')
        ]);

        return view('marketing.dashboard.index', [
            'months' => DateHelper::monthsOption(),
            'marketingEmployees' => $marketingEmployees,
            'salesOrders' => $salesOrders,
            'salesOrderDetails' => $salesOrderDetails,
        ]);
    }
}
