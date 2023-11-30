<?php

namespace App\Http\Controllers\Accounting\PettyCash;

use App\Domains\Accounting\PettyCash\PettyCashCashPaymentNumberCode;
use App\Domains\Accounting\PettyCash\PettyCashCashReceivedNumberCode;
use App\Domains\Accounting\PettyCash\PettyCashStatusValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\PettyCashRequest as AccountingPettyCashRequest;
use App\Models\PettyCash;
use App\Models\PettyCashDetail;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\PaymentType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PettyCashController extends Controller
{
    private const PETTY_CASH_CHART_OF_ACCOUNT_ID = 675;

    public function __construct() {}

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $pettyCashes = PettyCash::all();

        return view('accounting.petty-cash.petty-cash.index', [
            'pettyCashes' => $pettyCashes,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $employees = Employee::all();

        return view('accounting.petty-cash.petty-cash.create', [
            'employees' => $employees,
            'pettyCashCashPaymentNumberCode' => PettyCashCashPaymentNumberCode::create(),
            'pettyCashCashReceivedNumberCode' => PettyCashCashReceivedNumberCode::create(),
        ]);
    }

    function edit($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $pettyCash = PettyCash::findOrFail($id);

        return view('accounting.petty-cash.petty-cash.edit', [
            'pettyCash' => $pettyCash,
        ]);
    }

    function store(AccountingPettyCashRequest $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            if (!empty($request->received_by_employee_id)) {
                $employee = Employee::find($request->received_by_employee_id);
                $employeeName = $employee?->name ?? '';
            }

            PettyCash::create([
                'type' => $request->type,
                'petty_cash_number' => $request->petty_cash_number,
                'received_by' => $request->received_by ?? $employeeName,
                'received_by_type' => $request->received_by_type,
                'received_by_employee_id' => $request->received_by_employee_id,
                'manufacture_year' => $request->manufacture_year,
                'date' => $request->date,
                'information' => $request->information,
            ]);

            DB::commit();

            return redirect()->route('accounting.petty-cash.petty-cash.index')->with('success', __('Petty cash successfully created.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function update(AccountingPettyCashRequest $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $pettyCash = PettyCash::findOrFail($id);

            $pettyCash->fill($request->all());
            $pettyCash->save();

            $pettyCashDetails = PettyCashDetail::where('petty_cash_id', $id)->get();

            if ($pettyCash->status == PettyCashStatusValue::STATUS_DONE) {
                $this->storeJournalEntry($pettyCash, $pettyCashDetails);
            }

            DB::commit();

            return redirect()->route('accounting.petty-cash.petty-cash.index')->with('success', __('Cash payment successfully updated.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function duplicate($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $pettyCash = PettyCash::find($id);
            $newPettyCash = $pettyCash->replicate();
            $newPettyCash->save();

            $pettyCashDetails = PettyCashDetail::where('petty_cash_id', $id);

            if (!empty($pettyCashDetails)) {
                foreach ($pettyCashDetails->get() as $value) {
                    $newPettyCashDetails = $value->replicate();
                    $newPettyCashDetails->petty_cash_id = $newPettyCash->id;
                    $newPettyCashDetails->save();
                }
            }

            DB::commit();

            return redirect()->route('accounting.petty-cash.petty-cash.index')->with('success', __('Cash payment successfully duplicated.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with(['error' => 'Duplicate data gagal!']);
        }
    }

    function destroy($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $pettyCash = PettyCash::find($id);
            $pettyCash->delete();

            DB::commit();

            return redirect()->route('accounting.petty-cash.petty-cash.index')->with('success', __('Cash payment successfully deleted.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }

    function print($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $pettyCash = PettyCash::with('details')->findOrFail($id);

        return view('accounting.petty-cash.petty-cash.print', [
            'pettyCash' => $pettyCash,
        ]);
    }

    private function storeJournalEntry($pettyCash, $pettyCashDetails)
    {
        $journal              = new JournalEntry();
        $journal->journal_id  = $this->journalNumber();
        $journal->date        = $pettyCash->date;
        $journal->reference   = $pettyCash->petty_cash_number;
        $journal->description = $pettyCash->description;
        $journal->status = PettyCashStatusValue::STATUS_DONE;
        $journal->created_by  = Auth::user()->id;
        $journal->save();

        foreach ($pettyCashDetails as $detail) {
            $chartOfAccountId = PaymentType::where('name', $detail->payment_type)->first()->chart_of_account_id;

            // Debit
            $journalItem              = new JournalItem();
            $journalItem->journal     = $journal->id;
            $journalItem->account     = $chartOfAccountId;
            $journalItem->description = ($detail->payment_type ?? '') . ' ' . ($detail->license_plate ? 'Nopol ' . $detail->license_plate : '');
            $journalItem->debit       = $detail->nominal ?? 0;
            $journalItem->credit      = 0;
            $journalItem->save();

            // Credit
            $journalItem              = new JournalItem();
            $journalItem->journal     = $journal->id;
            $journalItem->account     = self::PETTY_CASH_CHART_OF_ACCOUNT_ID;
            $journalItem->description = 'Kas Kecil';
            $journalItem->debit       = 0;
            $journalItem->credit      = $detail->nominal ?? 0;
            $journalItem->save();
        }
    }

    private function journalNumber()
    {
        $latest = JournalEntry::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->journal_id + 1;
    }
}
