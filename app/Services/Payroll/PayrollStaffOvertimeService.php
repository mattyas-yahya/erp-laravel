<?php

namespace App\Services\Payroll;

use App\Domains\Payroll\StaffOvertimeValue;
use App\Http\Requests\PayrollStaffOvertimeRequest;
use App\Repositories\Hrm\Payroll\PayrollStaffOvertimeEloquentRepository;

class PayrollStaffOvertimeService
{
    protected $payrollStaffOvertimeRepo;

    public function __construct(
        PayrollStaffOvertimeEloquentRepository $payrollStaffOvertimeRepo,
    )
    {
        $this->payrollStaffOvertimeRepo = $payrollStaffOvertimeRepo;
    }

    public function getHeaders()
    {
        return StaffOvertimeValue::HEADER;
    }

    public function getPayrollStaffOvertimes()
    {
        return $this->payrollStaffOvertimeRepo->all();
    }

    public function findOvertime($id)
    {
        return $this->payrollStaffOvertimeRepo->find($id);
    }

    public function createOvertime(PayrollStaffOvertimeRequest $request)
    {
        return $this->payrollStaffOvertimeRepo->create($request);
    }

    public function updateOvertime(PayrollStaffOvertimeRequest $request, $id)
    {
        return $this->payrollStaffOvertimeRepo->update($request, $id);
    }

    public function deleteOvertime(string $id)
    {
        $overtime = $this->payrollStaffOvertimeRepo->find($id);

        if ($overtime) {
            return $this->payrollStaffOvertimeRepo->delete($id);
        }

        return 0;
    }
}
