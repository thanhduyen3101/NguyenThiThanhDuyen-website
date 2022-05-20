<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Order_Detail\OrderDetailRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class DashboardController extends Controller
{
    protected $userRepository;
    protected $orderRepository;
    protected $orderDetailRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        OrderRepositoryInterface $orderRepository,
        OrderDetailRepositoryInterface $orderDetailRepository
    ) {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function getTotal() {
        try {
            $salesman = $this->userRepository->getUserByType('SM');
            $order_cart = $this->orderRepository->getOrderBySTT('STT1');
            // dd(count($order_cart));
            $order_wait = $this->orderRepository->getOrderBySTT('STT2');
            $order_confirmed = $this->orderRepository->getOrderBySTT('STT4');
            $detail = $this->orderDetailRepository->getAllOrderDetail();
            if($detail) {
                $revenue = 0;
                for ($i = 0; $i<count($detail); $i++) {
                    $revenue = $revenue + ($detail[$i]->price*$detail[$i]->quantity); 
                }
            }
            $data = array([
                'salesman' => count($salesman),
                'order_cart' => count($order_cart),
                'order_ordered' => count($order_confirmed)+count($order_wait),
                'revenue' => $revenue
            ]);
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
