<?php

namespace App\Domains\Payroll;

class StaffOvertimeValue
{
    const HEADER = [
        'Jenis Lembur',
        'Waktu (jam)',
        'Perhitungan Waktu (jam)',
        'Uang Lembur (jam)',
        'Total Lemburan',
    ];

    public static function data() {
        return collect([
            (object) [
                'type' => 'Hari Biasa (jam hidup)',
                'time_worked' => 1,
                'time_calculation' => 1.5,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 37500
            ],
            (object) [
                'type' => 'Hari Biasa (jam hidup)',
                'time_worked' => 2,
                'time_calculation' => 4,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 100000
            ],
            (object) [
                'type' => 'Hari Biasa (jam hidup)',
                'time_worked' => 3,
                'time_calculation' => 6,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 150000
            ],
            (object) [
                'type' => 'Hari Libur / Hari Besar',
                'time_worked' => 1,
                'time_calculation' => 2,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 50000
            ],
            (object) [
                'type' => 'Hari Libur / Hari Besar',
                'time_worked' => 2,
                'time_calculation' => 4,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 100000
            ],
            (object) [
                'type' => 'Hari Libur / Hari Besar',
                'time_worked' => 3,
                'time_calculation' => 6,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 150000
            ],
            (object) [
                'type' => 'Jam Mati',
                'time_worked' => 1,
                'time_calculation' => 1,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 25000
            ],
            (object) [
                'type' => 'Jam Mati',
                'time_worked' => 2,
                'time_calculation' => 2,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 50000
            ],
            (object) [
                'type' => 'Jam Mati',
                'time_worked' => 3,
                'time_calculation' => 3,
                'overtime_pay_per_hour' => 25000,
                'overtime_pay_total' => 75000
            ]
        ]);
    }
}
