<?php

namespace App\Http\Controllers\Accounting\Config;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $paymentTypes = PaymentType::with(['chartOfAccount'])->get();

        return view('accounting.config.payment-type.index')->with([
            'paymentTypes' => $paymentTypes,
        ]);
    }

    public function create()
    {
        $chartOfAccounts = ChartOfAccount::select(\DB::raw('CONCAT(code, " - ", name) AS code_name, id'))->where('created_by', \Auth::user()->creatorId())->get()->pluck('code_name', 'id');
        $chartOfAccounts->prepend('--', '');

        return view('accounting.config.payment-type.create', [
            'chartOfAccounts' => $chartOfAccounts,
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|max:100',
                'chart_of_account_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $paymentType = new PaymentType();
        $paymentType->name = $request->name;
        $paymentType->chart_of_account_id = $request->chart_of_account_id;
        $paymentType->save();

        return redirect()->route('accounting.config.payment-type.index')->with('success', __('Payment type successfully created.'));
    }

    public function edit($id)
    {
        $paymentType = PaymentType::find($id);

        $chartOfAccounts = ChartOfAccount::select(\DB::raw('CONCAT(code, " - ", name) AS code_name, id'))->where('created_by', \Auth::user()->creatorId())->get()->pluck('code_name', 'id');
        $chartOfAccounts->prepend('--', '');

        // if ($paymentType->created_by !== \Auth::user()->creatorId()) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        return view('accounting.config.payment-type.edit', compact('paymentType', 'chartOfAccounts'));
    }

    public function update(Request $request, $id)
    {
        $paymentType = PaymentType::find($id);

        // if ($paymentType->created_by !== \Auth::user()->creatorId()) {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }

        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|max:20',
                'chart_of_account_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $paymentType->name = $request->name;
        $paymentType->chart_of_account_id = $request->chart_of_account_id;
        $paymentType->save();

        return redirect()->route('accounting.config.payment-type.index')->with('success', __('Payment type successfully updated.'));
    }

    public function destroy($id)
    {
        $paymentType = PaymentType::find($id);

        // if ($paymentType->created_by !== \Auth::user()->creatorId()) {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }

        $paymentType->delete();

        return redirect()->route('accounting.config.payment-type.index')->with('success', __('Payment type successfully deleted.'));
    }
}
