<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterPayrollOvertimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Domains\Payroll\StaffOvertimeValue::data() as $data) {
            DB::table('payroll_staff_overtimes')->insert([
                'type' => $data->type,
                'time_worked' => $data->time_worked,
                'time_calculation' => $data->time_calculation,
                'overtime_pay_per_hour' => $data->overtime_pay_per_hour,
                'overtime_pay_total' => $data->overtime_pay_total,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (\App\Domains\Payroll\DriverOvertimeValue::data() as $data) {
            DB::table('payroll_driver_overtimes')->insert([
                'rite' => $data->rite,
                'overtime_pay_per_hour' => $data->overtime_pay_per_hour,
                'overtime_pay_total' => $data->overtime_pay_total,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
