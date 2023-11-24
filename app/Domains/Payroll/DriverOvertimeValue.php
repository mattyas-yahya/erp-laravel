<?php

namespace App\Domains\Payroll;

class DriverOvertimeValue
{
    const HEADER = [
        'Rite',
        'Uang Lembur (jam)',
        'Total Lemburan',
    ];

    public static function data() {
        return collect([
            (object) [
                'rite' => 1,
                'overtime_pay_per_hour' => 50000,
                'overtime_pay_total' => 50000
            ],
            (object) [
                'rite' => 2,
                'overtime_pay_per_hour' => 50000,
                'overtime_pay_total' => 100000
            ],
            (object) [
                'rite' => 3,
                'overtime_pay_per_hour' => 50000,
                'overtime_pay_total' => 150000
            ],
        ]);
    }
}
