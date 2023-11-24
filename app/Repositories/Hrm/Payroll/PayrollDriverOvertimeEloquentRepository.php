<?php

namespace App\Repositories\Hrm\Payroll;

use App\Models\PayrollDriverOvertime;

class PayrollDriverOvertimeEloquentRepository
{
    public function all()
    {
        $payrollDriverOvertimes = PayrollDriverOvertime::where('created_by', '=', \Auth::user()->creatorId())
            ->get();

        return $payrollDriverOvertimes;
    }

    public function find($id)
    {
        $payrollDriverOvertime = PayrollDriverOvertime::find($id);

        return $payrollDriverOvertime;
    }

    public function create($request)
    {
        return PayrollDriverOvertime::create([
            'rite' => $request->rite,
            'overtime_pay_per_hour' => $request->overtime_pay_per_hour,
            'overtime_pay_total' => $request->overtime_pay_total,
        ]);
    }

    public function update($request, $id)
    {
        $schedule = PayrollDriverOvertime::findOrFail($id);

        $schedule->fill($request->all());
        $schedule->save();

        return $schedule;
    }

    public function delete(string $id)
    {
        return PayrollDriverOvertime::destroy($id);
    }
}
