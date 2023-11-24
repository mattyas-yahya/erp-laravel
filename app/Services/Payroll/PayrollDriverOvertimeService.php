<?php

namespace App\Services\Payroll;

use App\Domains\Payroll\DriverOvertimeValue;
use App\Http\Requests\PayrollDriverOvertimeRequest;
use App\Repositories\Hrm\Payroll\PayrollDriverOvertimeEloquentRepository;

class PayrollDriverOvertimeService
{
    protected $payrollDriverOvertimeRepo;

    public function __construct(
        PayrollDriverOvertimeEloquentRepository $payrollDriverOvertimeRepo,
    )
    {
        $this->payrollDriverOvertimeRepo = $payrollDriverOvertimeRepo;
    }

    public function getHeaders()
    {
        return DriverOvertimeValue::HEADER;
    }

    public function getPayrollDriverOvertimes()
    {
        return $this->payrollDriverOvertimeRepo->all();
    }

    public function findOvertime($id)
    {
        return $this->payrollDriverOvertimeRepo->find($id);
    }

    public function createOvertime(PayrollDriverOvertimeRequest $request)
    {
        return $this->payrollDriverOvertimeRepo->create($request);
    }

    public function updateOvertime(PayrollDriverOvertimeRequest $request, $id)
    {
        return $this->payrollDriverOvertimeRepo->update($request, $id);
    }

    public function deleteOvertime(string $id)
    {
        $overtime = $this->payrollDriverOvertimeRepo->find($id);

        if ($overtime) {
            return $this->payrollDriverOvertimeRepo->delete($id);
        }

        return 0;
    }
}
