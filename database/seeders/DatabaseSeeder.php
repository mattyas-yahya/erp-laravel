<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PlansTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProductionPermissionSeeder::class);
        $this->call(MarketingPermissionSeeder::class);
        $this->call(MasterPayrollOvertimeSeeder::class);
        $this->call(PaymentTermPermissionSeeder::class);
        $this->call(PurchaseApprovalPermissionSeeder::class);
        $this->call(ProductionDashboardPermissionSeeder::class);
    }
}
