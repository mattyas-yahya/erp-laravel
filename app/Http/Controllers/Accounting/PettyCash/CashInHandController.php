<?php

namespace App\Http\Controllers\Accounting\PettyCash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\CashInHandRequest as AccountingCashInHandRequest;
use App\Domains\Accounting\PettyCash\CashInHandNominalValue;
use App\Models\CashInHand;
use App\Models\CashInHandDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashInHandController extends Controller
{
    public function __construct() {}

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $cashInHands = CashInHand::all();

        return view('accounting.petty-cash.cash-in-hand.index', [
            'cashInHands' => $cashInHands,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        return view('accounting.petty-cash.cash-in-hand.create', [
            'nominals' => (new CashInHandNominalValue)->nominals,
        ]);
    }

    function edit($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $cashInHand = CashInHand::findOrFail($id);
        $cashInHandDetail = CashInHandDetail::findOrFail($id);

        return view('accounting.petty-cash.cash-in-hand.edit', [
            'nominals' => (new CashInHandNominalValue)->nominals,
            'cashInHand' => $cashInHand,
            'cashInHandDetail' => $cashInHandDetail,
        ]);
    }

    function store(AccountingCashInHandRequest $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $cashInHand = CashInHand::create([
                'cash_in_hand_number' => $request->cash_in_hand_number,
                'date' => $request->date,
                'initial_balance' => $request->initial_balance,
                'kasbon_balance' => $request->kasbon_balance,
                'account_balance' => $request->account_balance,
                'information' => $request->information ?? '',
            ]);

            CashInHandDetail::create([
                'cash_in_hand_id' => $cashInHand->id,
                'one_hundred_thousand_notes' => $request->one_hundred_thousand_notes ?? 0,
                'seventy_five_thousand_notes' => $request->seventy_five_thousand_notes ?? 0,
                'fifty_thousand_notes' => $request->fifty_thousand_notes ?? 0,
                'twenty_thousand_notes' => $request->twenty_thousand_notes ?? 0,
                'ten_thousand_notes' => $request->ten_thousand_notes ?? 0,
                'five_thousand_notes' => $request->five_thousand_notes ?? 0,
                'two_thousand_notes' => $request->two_thousand_notes ?? 0,
                'one_thousand_notes' => $request->one_thousand_notes ?? 0,
                'five_hundred_notes' => $request->five_hundred_notes ?? 0,
                'two_hundred_notes' => $request->two_hundred_notes ?? 0,
                'one_hundred_notes' => $request->one_hundred_notes ?? 0,
            ]);

            DB::commit();

            return redirect()->route('accounting.petty-cash.cash-in-hand.index')->with('success', __('Petty cash successfully created.'));
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();

            // return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function update(AccountingCashInHandRequest $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $cashInHand = CashInHand::findOrFail($id);

            $cashInHand->fill($request->all());
            $cashInHand->save();

            $cashInHandDetails = CashInHandDetail::where('cash_in_hand_id', $id);
            $cashInHandDetails->fill($request->all());
            $cashInHandDetails->save();

            DB::commit();

            return redirect()->route('accounting.petty-cash.cash-in-hand.index')->with('success', __('Cash-in-hand successfully updated.'));
        } catch (\Throwable $e) {
            dd($e);

            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function destroy($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $cashInHand = CashInHand::find($id);
            $cashInHandDetail = CashInHandDetail::where('cash_in_hand_id', $cashInHand->id);
            $cashInHand->delete();
            $cashInHandDetail->delete();

            DB::commit();

            return redirect()->route('accounting.petty-cash.cash-in-hand.index')->with('success', __('Cash-in-hand successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
