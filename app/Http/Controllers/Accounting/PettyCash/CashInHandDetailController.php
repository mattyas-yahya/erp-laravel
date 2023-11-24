<?php

namespace App\Http\Controllers\Accounting\PettyCash;

use App\Http\Controllers\Controller;
use App\Models\PettyCash;
use App\Models\PettyCashDetail;
use App\Models\PaymentType;
use App\Http\Requests\Accounting\PettyCashDetailRequest as AccountingPettyCashDetailRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashInHandDetailController extends Controller
{
    public function __construct() {}

    function index(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $cashPayment = PettyCash::findOrFail($id);
        $cashPaymentDetails = PettyCashDetail::where('petty_cash_id', $id)->get();

        return view('accounting.petty-cash.petty-cash.detail.index', [
            'cashPayment' => $cashPayment,
            'cashPaymentDetails' => $cashPaymentDetails,
        ]);
    }

    function form($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $cashPayment = PettyCash::findOrFail($id);
        $cashPaymentDetails = PettyCashDetail::where('petty_cash_id', $id)->get();
        $paymentTypes = PaymentType::all();

        return view('accounting.petty-cash.petty-cash.detail.form', [
            'cashPayment' => $cashPayment,
            'cashPaymentDetails' => $cashPaymentDetails,
            'paymentTypes' => $paymentTypes,
        ]);
    }

    function store(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }/

        try {
            DB::beginTransaction();

            $payload = collect([]);
            foreach ($request->payment_type as $key => $value) {
                $payload->push([
                    'petty_cash_id' => $id,
                    'payment_type' => $request->payment_type[$key],
                    'license_plate' => $request->license_plate[$key] ?? '',
                    'information' => $request->information[$key] ?? '',
                    'nominal' => $request->nominal[$key],
                ]);
            }

            $cashPaymentDetails = PettyCashDetail::where('petty_cash_id', $id);
            $cashPaymentDetails->delete();

            PettyCashDetail::insert($payload->toArray());

            DB::commit();

            return redirect()->route('accounting.petty-cash.petty-cash.detail.index', $id)->with('success', __('Petty cash successfully created.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }
}
