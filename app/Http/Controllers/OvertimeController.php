<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Overtime;
use App\Services\Payroll\PayrollStaffOvertimeService;

class OvertimeController extends Controller
{
    public function __construct(
        PayrollStaffOvertimeService $payrollStaffOvertimeSvc
    ) {
        $this->payrollStaffOvertimeSvc = $payrollStaffOvertimeSvc;
    }

    public function overtimeCreate($id)
    {
        $employee = Employee::find($id);
        $payrollStaffOvertimes = $this->payrollStaffOvertimeSvc->getPayrollStaffOvertimes();

        return view('overtime.create', [
            'employee' => $employee,
            'payrollStaffOvertimes' => $payrollStaffOvertimes,
        ]);
    }

    public function store(Request $request)
    {
        if (!\Auth::user()->can('create overtime')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'employee_id' => 'required',
                'title' => 'required',
                'number_of_days' => 'required',
                'hours' => 'required',
                'rate' => 'required',
                'type' => 'required',
                'note' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $overtime                 = new Overtime();
        $overtime->employee_id    = $request->employee_id;
        $overtime->title          = $request->title;
        $overtime->number_of_days = $request->number_of_days;
        $overtime->hours          = $request->hours;
        $overtime->rate           = $request->rate;
        $overtime->type           = $request->type;
        $overtime->note           = $request->note;
        $overtime->created_by     = \Auth::user()->creatorId();
        $overtime->save();

        return redirect()->back()->with('success', __('Overtime  successfully created.'));
    }

    public function edit($overtime)
    {
        $overtime = Overtime::find($overtime);
        if (!\Auth::user()->can('edit overtime')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        if ($overtime->created_by != \Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $payrollStaffOvertimes = $this->payrollStaffOvertimeSvc->getPayrollStaffOvertimes();

        return view('overtime.edit', [
            'overtime' => $overtime,
            'payrollStaffOvertimes' => $payrollStaffOvertimes,
        ]);
    }

    public function update(Request $request, $overtime)
    {
        $overtime = Overtime::find($overtime);
        if (\Auth::user()->can('edit overtime')) {
            if ($overtime->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'title' => 'required',
                        'number_of_days' => 'required',
                        'hours' => 'required',
                        'rate' => 'required',
                        'type' => 'required',
                        'note' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $overtime->title          = $request->title;
                $overtime->number_of_days = $request->number_of_days;
                $overtime->hours          = $request->hours;
                $overtime->rate           = $request->rate;
                $overtime->save();

                return redirect()->back()->with('success', __('Overtime successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Overtime $overtime)
    {
        if (\Auth::user()->can('delete overtime')) {
            if ($overtime->created_by == \Auth::user()->creatorId()) {
                $overtime->delete();

                return redirect()->back()->with('success', __('Overtime successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
