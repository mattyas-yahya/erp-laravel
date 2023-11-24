<?php

namespace App\Exports;

use App\Services\Marketing\SalesOrderService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportMarketingExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }
    
    public function headings(): array
    {
        $productName = DB::table('goods_receipt_details')->pluck('product_name')->toArray();
        $data = array_unique($productName);
        $data2 = implode(", ",$data);
        return [
            "Pelanggan",
            "Pemasaran",
            $data2,
            "Total"
        ];
    }

    public function collection()
    {
        // $data = DB::table('sales_orders')
        //     ->select([
        //         'sales_orders.customer_id',
        //         'customers.name as cust_name',
        //         'employees.name as emp_name',
        //     ])
        //     ->join('customers', 'sales_orders.customer_id', '=', 'customers.id')
        //     ->join('employees', 'sales_orders.employee_id', '=', 'employees.id')
        //     ->where('status', "=", "Done");

        // if (!empty($filters['month'])) {
        //     $data = $data->whereMonth('production_schedules.production_date', $filters['month']);
        // }

        // if (!empty($filters['year'])) {
        //     $data = $data->whereYear('production_schedules.production_date', $filters['year']);
        // }

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

        // return $data->get();

        return $this->salesOrderService->reportAll($this->filters);
    }

    public function map($reportMarketingDetails): array
    {
        return [
            // $reportMarketingDetails->customer_id,
            $reportMarketingDetails->cust_name,
            $reportMarketingDetails->emp_name,
        ];
    }
}
