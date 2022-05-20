<?php
namespace App\Repositories\Order_Detail;

interface OrderDetailRepositoryInterface
{
    public function getOrderDetailByOrderId($order_id);

    public function getLastOrderDetailId();

    public function getAllOrderDetail();

    public function getOrderDetailBySalesman($salesman_id);
}