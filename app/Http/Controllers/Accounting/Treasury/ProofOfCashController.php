<?php

namespace App\Http\Controllers\Accounting\Treasury;

use App\Http\Controllers\Controller;
use App\Models\BillPayment;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProofOfCashController extends Controller
{
    public function __construct() {}

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $filterValues = [
            'status`' => [
                'Semua',
                'Masuk',
                'Keluar'
            ],
        ];

        $invoicePayments = InvoicePayment::with(['invoice.customer', 'paymentMethod'])->get();
        $billPayments = BillPayment::with(['bill.vender', 'paymentMethod'])->get();

        return view('accounting.treasury.proof-of-cash.index', [
            'filterValues' => $filterValues,
            'invoicePayments' => $request->status == 'Masuk' ? $invoicePayments : [],
            'billPayments' => $request->status == 'Keluar' ? $billPayments : [],
        ]);
    }
}
