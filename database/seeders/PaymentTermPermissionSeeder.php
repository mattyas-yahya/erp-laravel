<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PaymentTermPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'manage payment term',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $save = Permission::insert($permissions);

         // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $permissions = array_map(fn($value) => [
            'name' => $value['name']
        ], $permissions);

        $companyRole = Role::where('name', 'company')->first();
        $companyRole->givePermissionTo($permissions);
    }
}
