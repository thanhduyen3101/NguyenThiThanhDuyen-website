<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getProductById($id);

    public function getAllProduct();

    public function getProductByCourseId($course_id);

    public function getLastProductId();

    public function getProductByOwner($owner_id);
}