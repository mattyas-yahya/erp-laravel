<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\CustomerShippingAddress;

class CustomerShippingAddressMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::all();

        $customers->each(function ($customer) {
            CustomerShippingAddress::create([
                'customer_id' => $customer->id,
                'name' => $customer->shipping_name,
                'country' => $customer->shipping_country,
                'state' => $customer->shipping_state,
                'city' => $customer->shipping_city,
                'phone' => $customer->shipping_phone,
                'zip' => $customer->shipping_zip,
                'address' => $customer->shipping_address,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        });
    }
}
