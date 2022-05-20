<?php

namespace App\Repositories\Customer;

use App\Repositories\RepositoryEloquent;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerRepositoryEloquent extends RepositoryEloquent implements CustomerRepositoryInterface
{
    public function getModel()
    {
        return Customer::class;
    }

    public function getCustomerById($id) {
        $result = DB::table('customer')
        ->where('customer.customer_id', $id)
        ->first();
        return $result;
    }
    
    public function getLastCustomerId() {
        $result = DB::table('customer')
        ->orderByDesc('customer_id')
        ->first();
        return $result;
    }

    public function getAllCustomer() {
        $result = $this->_model
            ->select(
                'customer.id',
                'customer.customer_id',
                'customer.name',
                'customer.owner',
                'customer.phone',
                'customer.address',
                'customer.lat',
                'customer.long',
                'customer.area_id',
                'customer.images'
            )
            ->orderBy('customer_id', 'desc')
            ->get();
        return $result;
    }

}