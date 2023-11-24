<?php

namespace App\Repositories\Customer;

use App\Models\Customer;

class CustomerEloquentRepository
{
    public function all()
    {
        $customers = Customer::where('created_by', \Auth::user()->creatorId())
            ->get();

        return $customers;
    }
}
