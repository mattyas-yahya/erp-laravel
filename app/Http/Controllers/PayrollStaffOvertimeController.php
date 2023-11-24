<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PayrollStaffOvertimeRequest;
use App\Services\Payroll\PayrollStaffOvertimeService;

class PayrollStaffOvertimeController extends Controller
{
    private $payrollStaffOvertimeSvc;

    public function __construct(
        PayrollStaffOvertimeService $payrollStaffOvertimeSvc
    ) {
        $this->payrollStaffOvertimeSvc = $payrollStaffOvertimeSvc;
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

        $headers = $this->payrollStaffOvertimeSvc->getHeaders();
        $overtimes = $this->payrollStaffOvertimeSvc->getPayrollStaffOvertimes();

        return view('payroll.overtime.staff.index', [
            'headers' => $headers,
            'overtimes' => $overtimes,
        ]);
    }

    function create()
    {
        if (!Auth::user()->can('manage pay slip')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('payroll.overtime.staff.create');
    }

    function edit($id)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $overtime = $this->payrollStaffOvertimeSvc->findOvertime($id);

        if ($overtime->created_by !== Auth::id()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('payroll.overtime.staff.edit', [
            'overtime' => $overtime,
        ]);
    }

    function store(PayrollStaffOvertimeRequest $request)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $store = $this->payrollStaffOvertimeSvc->createOvertime($request);

        if (!$store) {
            return redirect()->back()->with('error', 'Overtime create failed.');
        }

        return redirect()->back()->with('success', 'Overtime successfully created.');
    }

    function update(PayrollStaffOvertimeRequest $request, $id)
    {
        if (!Auth::user()->can('manage pay slip')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $update = $this->payrollStaffOvertimeSvc->updateOvertime($request, $id);

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

        $delete = $this->payrollStaffOvertimeSvc->deleteOvertime($id);

        if (!$delete) {
            return redirect()->back()->with('error', 'Overtime delete failed.');
        }

        return redirect()->back()->with('success', 'Overtime successfully deleted.');
    }
}
