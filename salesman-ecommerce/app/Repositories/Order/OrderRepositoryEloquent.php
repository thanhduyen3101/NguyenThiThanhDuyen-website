<?php

namespace App\Repositories\Order;

use App\Repositories\RepositoryEloquent;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepositoryEloquent extends RepositoryEloquent implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function getOrderById($id) {
        $result = DB::table('orders')
        ->where('orders.order_id', $id)
        ->first();
        return $result;
    }

    public function getOrderBySTT($status) {
        $result = DB::table('orders')
        ->where('orders.status', $status)
        ->get();
        return $result;
    }
    
    public function getLastOrderId() {
        $result = DB::table('orders')
        ->orderByDesc('order_id')
        ->first();
        return $result;
    }
    public function getCourseName($id) {
        $result = DB::table('categories')
        ->where('categories.course_id',$id)
        ->first();
        return $result;
    }

    public function getAllOrder() {
        $result = $this->_model
            ->select(
                'orders.id',
                'orders.order_id',
                'orders.student_id',
                'users.name as student_name',
                'orders.status',
                'status.name as status_name',
                'orders.created_at',
                'orders.updated_at',
                'categories.name as course_name'
            )
            ->join('users', 'users.user_id', '=', 'orders.student_id')
            ->join('status', 'status.status_id', '=', 'orders.status')
            ->join('categories', 'categories.course_id', '=', 'orders.course_id')
            ->orderBy('order_id', 'desc')
            ->get();
        return $result;
    }

    public function getAllOrderByTeacher($teacher_id)
    {
        $result = $this->_model
            ->select(
                'orders.id',
                'orders.order_id',
                'orders.student_id',
                'users.name as student_name',
                'orders.status',
                'status.name as status_name',
                'orders.created_at',
                'categories.name as course_name',
                'orders.updated_at',
            )
            ->join('users', 'users.user_id', '=', 'orders.student_id')
            ->join('categories', function($query) use($teacher_id) {
                $query->on('categories.course_id', 'orders.course_id')
                    ->where('categories.id_teacher', $teacher_id);
            })
            ->join('status', 'status.status_id', '=', 'orders.status')
            ->orderBy('order_id', 'desc')
            ->get();
        return $result;
    }

    public function getOrderByStudent($student_id) {
        $result = $this->_model
            ->select(
                'orders.id',
                'orders.order_id',
                'orders.student_id',
                'orders.course_id',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
            )
            ->where('orders.student_id', $student_id)
            ->orderBy('order_id', 'desc')
            ->get();
        return $result;
    }
    
    public function getOrderByCustomer($customer_id) {
        $result = $this->_model
            ->select(
                'orders.id',
                'orders.order_id',
                'orders.salesman_id',
                'orders.customer_id',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
            )
            ->where('orders.customer_id', $customer_id)
            ->orderBy('order_id', 'desc')
            ->get();
        return $result;
    }

    public function findOrderByStudentIdAndCourseId($student_id, $course_id) {
        $result = $this->_model
            ->select(
                'orders.id',
                'orders.order_id',
                'orders.student_id',
                'orders.course_id',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
            )
            ->where('orders.student_id', $student_id)
            ->where('orders.course_id', $course_id)
            ->where('orders.status', '!=', 'STT3')
            ->first();
        return $result;
    }

}