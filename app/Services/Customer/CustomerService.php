<?php

namespace App\Services\Customer;

use App\Repositories\Customer\CustomerEloquentRepository;

class CustomerService
{
    protected $customerRepo;

    public function __construct(
        CustomerEloquentRepository $customerRepo,
    )
    {
        $this->customerRepo = $customerRepo;
    }

    public function getCustomers()
    {
        return $this->customerRepo->all();
    }
}
