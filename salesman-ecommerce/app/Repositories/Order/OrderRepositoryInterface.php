<?php
namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function getOrderById($id);

    public function getOrderBySTT($status);

    public function getLastOrderId();

    public function getAllOrder();

    public function getAllOrderByTeacher($teacher_id);

    public function getOrderByStudent($student_id);

    public function getOrderByCustomer($customer_id);

    public function findOrderByStudentIdAndCourseId($student_id, $course_id);
}