<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class AccountingDebtController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('created_by', '=', \Auth::user()->creatorId())->get();

        return view('accounting.debt.index')->with([
            'invoices' => $invoices,
        ]);
    }
}
