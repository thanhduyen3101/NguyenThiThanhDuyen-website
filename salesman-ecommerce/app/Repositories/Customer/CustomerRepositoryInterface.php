<?php
namespace App\Repositories\Customer;

interface CustomerRepositoryInterface
{
    public function getCustomerById($id);

    public function getLastCustomerId();

    public function getAllCustomer();
}