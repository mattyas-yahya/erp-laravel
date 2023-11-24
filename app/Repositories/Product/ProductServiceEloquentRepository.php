<?php

namespace App\Repositories\Product;

use Illuminate\Support\Facades\Auth;
use App\Models\ProductService;

class ProductServiceEloquentRepository
{
    public function all()
    {
        $productServices = ProductService::where('created_by', Auth::user()->creatorId())
        ->get();

        return $productServices;
    }
}
