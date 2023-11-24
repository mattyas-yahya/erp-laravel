<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AccountingConfigPaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::where('created_by', '=', \Auth::user()->creatorId())->get();

        return view('accounting.config.payment-method.index')->with([
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function create()
    {
        return view('accounting.config.payment-method.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|max:20',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $paymentMethod             = new PaymentMethod();
        $paymentMethod->name       = $request->name;
        $paymentMethod->created_by = \Auth::user()->creatorId();
        $paymentMethod->save();

        return redirect()->route('accounting.config.payment-method.index')->with('success', __('Payment method successfully created.'));
    }

    public function edit($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod->created_by !== \Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('accounting.config.payment-method.edit', compact('paymentMethod'));
    }

    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod->created_by !== \Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required|max:20',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $paymentMethod->name = $request->name;
        $paymentMethod->save();

        return redirect()->route('accounting.config.payment-method.index')->with('success', __('Payment method successfully updated.'));
    }

    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod->created_by !== \Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $paymentMethod->delete();

        return redirect()->route('accounting.config.payment-method.index')->with('success', __('Payment method successfully deleted.'));
    }
}
