<?php

namespace App\Repositories\Hrm\Payroll;

use App\Models\PayrollStaffOvertime;

class PayrollStaffOvertimeEloquentRepository
{
    public function all()
    {
        $payrollStaffOvertimes = PayrollStaffOvertime::where('created_by', '=', \Auth::user()->creatorId())
            ->get();

        return $payrollStaffOvertimes;
    }

    public function find($id)
    {
        $payrollStaffOvertime = PayrollStaffOvertime::find($id);

        return $payrollStaffOvertime;
    }

    public function create($request)
    {
        return PayrollStaffOvertime::create([
            'type' => $request->type,
            'time_worked' => $request->time_worked,
            'time_calculation' => $request->time_calculation,
            'overtime_pay_per_hour' => $request->overtime_pay_per_hour,
            'overtime_pay_total' => $request->overtime_pay_total,
        ]);
    }

    public function update($request, $id)
    {
        $overtime = PayrollStaffOvertime::findOrFail($id);

        $overtime->fill($request->all());
        $overtime->save();

        return $overtime;
    }

    public function delete(string $id)
    {
        return PayrollStaffOvertime::destroy($id);
    }
}
