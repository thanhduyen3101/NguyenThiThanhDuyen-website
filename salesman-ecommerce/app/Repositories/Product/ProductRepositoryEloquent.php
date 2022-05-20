<?php

namespace App\Repositories\Product;

use App\Repositories\RepositoryEloquent;
use App\Models\Products;
use Illuminate\Support\Facades\DB;


class ProductRepositoryEloquent extends RepositoryEloquent implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Products::class;
    }

    public function getProductById($id) {
        $result = DB::table('products')
        ->where('products.product_id', $id)
        ->first();
        return $result;
    }
    
    public function getLastProductId() {
        $result = DB::table('products')
        ->orderByDesc('lesson_id')
        ->first();
        return $result;
    }

    public function getAllProduct() {
        $result = $this->_model
            ->select(
                'products.id',
                'products.product_id',
                'products.title',
                'products.owner_id',
                'users.name as owner_name',
                'products.category',
                'categories.name as category_name',
                'products.size',
                'products.price',
                'products.description',
                'products.image',
                'products.enabled',
                'products.created_at',
                'products.updated_at'
            )
            ->join('users', 'users.user_id', '=', 'products.owner_id')
            ->leftJoin('categories', 'categories.category_id', '=', 'products.category')
            ->where('products.enabled', 1)
            ->orderBy('product_id', 'desc')
            ->get();
        if ($result) {
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['image'])){
                    $path = '/static/image/product/'.$result[$i]['product_id'].'/'.$result[$i]['image'];
                    $result[$i]['image'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/product/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['image'] = $image;   
                }
            }
        }
        return $result;
    }

    public function getProductByCourseId($course_id) {
        $result = $this->_model
            ->select(
                'products.id',
                'products.lesson_id',
                'products.title',
                'products.course_id',
                'categories.name as course_name',
                'products.content',
                'products.image',
                'products.created_at',
                'products.updated_at'
            )
            ->join('categories', 'categories.course_id', '=', 'products.course_id')
            ->where('products.course_id', $course_id)
            ->orderBy('lesson_id', 'desc')
            ->get();
        if ($result) {
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['image'])){
                    $path = '/static/image/product/'.$result[$i]['lesson_id'].'/'.$result[$i]['image'];
                    $result[$i]['image'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/product/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['image'] = $image;   
                }
            }
        }
        return $result;
    }

    public function getProductByOwner($owner_id) {
        $result = $this->_model
            ->select(
                'products.id',
                'products.product_id',
                'products.title',
                'users.name as owner_name',
                'products.owner_id',
                'products.category',
                'products.size',
                'products.price',
                'products.description',
                'products.image',
                'products.enabled',
                'products.created_at',
                'products.updated_at'
            )
            ->join('users', 'users.user_id', '=', 'products.owner_id')
            ->where('products.owner_id', $owner_id)
            ->where('products.enabled', 1)
            ->orderBy('product_id', 'desc')
            ->get();
        if ($result) {
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['image'])){
                    $path = '/static/image/product/'.$result[$i]['product_id'].'/'.$result[$i]['image'];
                    $result[$i]['image'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/product/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['image'] = $image;   
                }
            }
        } 
        return $result;
    }

}