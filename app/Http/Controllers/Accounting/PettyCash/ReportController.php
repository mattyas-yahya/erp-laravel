<?php

namespace App\Http\Controllers\Accounting\PettyCash;

use App\Domains\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct() {}

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $filterValues = [
            'months' => DateHelper::monthsOption(),
            'years' => DateHelper::yearsOption(),
        ];

        $pettyCashes = DB::table('petty_cashes')
            ->select([
                'petty_cashes.id AS petty_cash_id',
                'petty_cashes.type AS petty_cash_type',
                'petty_cashes.date AS petty_cash_date',
                'petty_cashes.petty_cash_number AS petty_cash_number',
                'petty_cash_details.information AS information',
                'petty_cash_details.nominal AS nominal',
            ])
            ->join('petty_cash_details', 'petty_cashes.id', '=', 'petty_cash_details.petty_cash_id')
            ->where('petty_cashes.status', 'DONE')
            ->whereMonth('date', $request->month ?? date('m'))
            ->whereYear('date', $request->year ?? date('Y'))
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('petty_cash_id');

        return view('accounting.petty-cash.report.index', [
            'filterValues' => $filterValues,
            'currentMonthWeeks' => DateHelper::getMonthWeeks(),
            'pettyCashes' => $pettyCashes,
        ]);
    }
}
