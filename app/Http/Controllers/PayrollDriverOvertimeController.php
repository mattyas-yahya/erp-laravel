<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PayrollDriverOvertimeRequest;
use App\Services\Payroll\PayrollDriverOvertimeService;

class PayrollDriverOvertimeController extends Controller
{
    private $payrollDriverOvertimeSvc;

    public function __construct(
        PayrollDriverOvertimeService $payrollDriverOvertimeSvc
    ) {
        $this->payrollDriverOvertimeSvc = $payrollDriverOvertimeSvc;
    }

    public function index()
    {
        if (
            !\Auth::user()->can('manage pay slip')
            && !\Auth::user()->type != 'client'
            && !\Auth::user()->type != 'company'
        ) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $headers = $this->payrollDriverOvertimeSvc->getHeaders();
        $overtimes = $this->payrollDriverOvertimeSvc->getPayrollDriverOvertimes();

        return view('payroll.overtime.driver.index', [
            'headers' => $headers,
            'overtimes' => $overtimes,
        ]);
    }

    function show($id)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $overtime = $this->payrollDriverOvertimeSvc->findOvertime($id);

        return view('payroll.overtime.driver.show', [
            'overtime' => $overtime,
        ]);
    }

    function create()
    {
        if (!Auth::user()->can('manage pay slip')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('payroll.overtime.driver.create');
    }

    function edit($id)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $overtime = $this->payrollDriverOvertimeSvc->findOvertime($id);

        if ($overtime->created_by !== Auth::id()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('payroll.overtime.driver.edit', [
            'overtime' => $overtime,
        ]);
    }

    function store(PayrollDriverOvertimeRequest $request)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $store = $this->payrollDriverOvertimeSvc->createOvertime($request);

        if (!$store) {
            return redirect()->back()->with('error', 'Overtime create failed.');
        }

        return redirect()->back()->with('success', 'Overtime successfully created.');
    }

    function update(PayrollDriverOvertimeRequest $request, $id)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $update = $this->payrollDriverOvertimeSvc->updateOvertime($request, $id);

        if (!$update) {
            return redirect()->back()->with('error', 'Overtime update failed.');
        }

        return redirect()->back()->with('success', 'Overtime successfully updated.');
    }

    function destroy($id)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $delete = $this->payrollDriverOvertimeSvc->deleteOvertime($id);

        if (!$delete) {
            return redirect()->back()->with('error', 'Overtime delete failed.');
        }

        return redirect()->back()->with('success', 'Overtime successfully deleted.');
    }
}
