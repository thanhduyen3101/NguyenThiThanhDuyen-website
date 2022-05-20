<?php

namespace App\Repositories\Order_Detail;

use App\Repositories\RepositoryEloquent;
use App\Models\Order_Detail;
use Illuminate\Support\Facades\DB;

class OrderDetailRepositoryEloquent extends RepositoryEloquent implements OrderDetailRepositoryInterface
{
    public function getModel()
    {
        return Order_Detail::class;
    }

    public function getLastOrderDetailId() {
        $result = DB::table('order_detail')
        ->orderByDesc('order_detail_id')
        ->first();
        return $result;
    }

    public function getOrderDetailByOrderId($order_id) {
        $result = DB::table('order_detail')
        ->select(
            'order_detail.id',
            'order_detail.order_detail_id',
            'order_detail.order_id',
            'order_detail.product_id',
            'products.title',
            'products.price',
            'products.image',
            'orders.customer_id',
            'orders.status',
            'orders.created_at',
            DB::raw('SUM(order_detail.quantity) as quantity')
        )
        ->join('products', 'products.product_id', '=', 'order_detail.product_id')
        ->join('orders', 'orders.order_id', '=', 'order_detail.order_id')
        ->where('order_detail.order_id', $order_id)
        ->groupBy('order_detail.product_id')
        ->get();
        if($result) {
            for ($i=0; $i < count($result); $i++) {
                if(!empty($result[$i]->image)){
                    $path = '/static/image/product/'.$result[$i]->product_id.'/'.$result[$i]->image;
                    $result[$i]->image = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/product/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]->image = $image;   
                }    
            }
        }
        return $result;
    }

    public function getAllOrderDetail() {
        $result = $this->_model
            ->select(
                'order_detail.id',
                'order_detail.order_detail_id',
                'order_detail.order_id',
                'orders.salesman_id',
                'order_detail.product_id',
                'order_detail.quantity',
                'products.title',
                'products.price',
                'orders.customer_id',
                'orders.status',
                'orders.created_at',
            )
            ->join('orders', 'orders.order_id', '=', 'order_detail.order_id')
            ->join('products', 'products.product_id', '=', 'order_detail.product_id')
            ->orderBy('order_detail_id', 'desc')
            ->get();
        return $result;
    }

    public function getOrderDetailBySalesman($salesman_id) {
        $result = $this->_model
            ->select(
                'order_detail.id',
                'order_detail.order_detail_id',
                'order_detail.order_id',
                'orders.salesman_id',
                'order_detail.product_id',
                'order_detail.quantity',
                'products.title',
                'products.price',
                'orders.customer_id',
                'orders.status',
                'orders.created_at',
            )
            ->join('orders', 'orders.order_id', '=', 'order_detail.order_id')
            ->join('products', 'products.product_id', '=', 'order_detail.product_id')
            ->where('orders.salesman_id', $salesman_id)
            ->orderBy('order_detail_id', 'desc')
            ->get();
        return $result;
    }

}