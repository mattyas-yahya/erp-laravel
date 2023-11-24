<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domains\Helpers\DateHelper;
use App\Exports\ReportMarketingExport;
use App\Models\Employee;
use App\Services\Marketing\SalesOrderService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class ReportMarketingController extends Controller
{
    private $salesOrderService;

    public function __construct(
        SalesOrderService $salesOrderService
    ) {
        $this->salesOrderService = $salesOrderService;
    }

    function index(Request $request)
    {
        if (!Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $marketingEmployees = Employee::whereRelation('designation', 'name', 'LIKE', '%' . 'Marketing' . '%')
            ->where('created_by', '=', \Auth::user()->creatorId())
            ->get();

        $filterValues = [
            'marketingEmployees' => $marketingEmployees,
            'months' => DateHelper::monthsOption(),
            'years' => DateHelper::yearsOption(),
        ];

        $salesOrders = $this->salesOrderService->getDoneSalesOrders($request);
        $salesOrderDetails = $this->salesOrderService->getSalesOrderDetails([
            'sales_order_ids' => $salesOrders->pluck('id')
        ]);

        return view('report.marketing.index', [
            'filterValues' => $filterValues,
            'salesOrders' => $salesOrders,
            'salesOrderDetails' => $salesOrderDetails,
        ]);
    }

    public function export_xls(Request $request)
    {
        // $productName = DB::table('goods_receipt_details')->pluck('product_name')->toArray();
        $filters = [
            'year' => $request->get('year') ?? date('Y'),
            'month' => $request->get('month') ?? date('m'),
        ];

        $name = 'report_marketing_' . date('Y-m-d h:i:s');
        $data = Excel::download(new ReportMarketingExport($filters), $name . '.xlsx');
        // $data = Excel::download(new MarketingStockExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;

    }

    function export_pdf(Request $request)
    {
        if (!\Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $marketingEmployees = Employee::whereRelation('designation', 'name', 'LIKE', '%' . 'Marketing' . '%')
            ->where('created_by', '=', \Auth::user()->creatorId())
            ->get();

        $filterValues = [
            'marketingEmployees' => $marketingEmployees,
            'months' => DateHelper::monthsOption(),
            'years' => DateHelper::yearsOption(),
        ];

        $salesOrders = $this->salesOrderService->getDoneSalesOrders($request);
        $salesOrderDetails = $this->salesOrderService->getSalesOrderDetails([
            'sales_order_ids' => $salesOrders->pluck('id')
        ]);
        return view('report.marketing.print_template.printview_pdf', [
            'filterValues' => $filterValues,
            'salesOrders' => $salesOrders,
            'salesOrderDetails' => $salesOrderDetails,
        ]);
    }
}
