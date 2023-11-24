<?php

namespace App\Http\Controllers\Accounting\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillMonitoringController extends Controller
{
    public function __construct() {}

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage sales order')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $invoicePayments = DB::table('invoice_payments')
            ->select([
                'invoices.issue_date AS invoice_issue_date',
                'employees.name AS marketing_name',
                'customers.name AS customer_name',
                'invoices.invoice_id AS invoice_number',
                'invoices.faktur_penjualan_number AS invoice_faktur_penjualan_number',
                'invoice_payments.amount AS invoice_amount',
                // tanggal surat jalan
                'payment_terms.days AS payment_term_days',
                // jatuh tempo sj
                // status (lunas, belum lunas)
                'invoice_payments.giro_number AS giro_number', // bank/no giro
                'invoice_payments.giro_date AS giro_date',
                'invoice_payments.amount AS giro_amount',
                // lama pembayaran
                // no memo giro
                // tanggal titip bank
                // keterangan
                // umur piutang
            ])
            ->join('invoices', 'invoice_payments.invoice_id', '=', 'invoices.id')
            ->join('sales_orders', 'invoices.ref_number', '=', 'sales_orders.id')
            ->join('employees', 'sales_orders.employee_id', '=', 'employees.id')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('payment_terms', 'payment_terms.id', '=', 'sales_orders.payment_term_id')
            ->latest('invoice_payments.created_at')
            ->get();

        return view('accounting.sales.bill-monitoring.index', [
            'invoicePayments' => $invoicePayments,
        ]);
    }
}
