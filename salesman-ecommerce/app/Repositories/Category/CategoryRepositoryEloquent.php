<?php

namespace App\Repositories\Category;

use App\Repositories\RepositoryEloquent;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class CategoryRepositoryEloquent extends RepositoryEloquent implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }
    
    public function getLastCategoryId() {
        $result = DB::table('categories')
        ->orderByDesc('course_id')
        ->first();
        return $result;
    }

    public function getAllCategoryForStudent() {
        $result = $this->_model
            ->select(
                'categories.id',
                'categories.course_id as course_id',
                'categories.name',
                'categories.image',  
                'categories.maximum_student',
                'categories.start_day',
                'categories.description',
                'categories.id_teacher',
                'categories.end_day',
                DB::raw('COUNT(products.id) as amount_registed')
            )
            ->leftjoin('products', 'products.course_id', 'categories.course_id')
            ->orderBy('course_id', 'desc')
            ->groupBy('course_id')
            ->where('start_day', '>', date('Y-m-d'))
            ->get();
        if ($result) {
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['image'])){
                    $path = '/static/image/category/'.$result[$i]['course_id'].'/'.$result[$i]['image'];
                    $result[$i]['image'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/category/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['image'] = $image;   
                }
            }
        }
        return $result;
    }

    public function findCategoryByStudentIdAndCourseId($course_id, $student_id) {
        $result = $this->_model
            ->select(
                'categories.id',
                'categories.course_id as course_id',
                'categories.name',
                'categories.image',  
                'categories.maximum_student',
                'categories.start_day',
                'categories.description',
                'categories.id_teacher',
                'categories.end_day',
                'orders.order_id as order_id',
                'orders.status as status',
                DB::raw('COUNT(products.id) as amount_registed')
            )
            ->leftjoin('products', 'products.course_id', 'categories.course_id')
            ->leftjoin('orders', function($query) use ($student_id){
                $query->on('orders.course_id', 'categories.course_id')
                    ->where('orders.student_id', $student_id);
            })
            ->where('categories.course_id', $course_id)
            ->first();
        if ($result) {
            if(!empty($result['image'])){
                $path = '/static/image/category/'.$result['course_id'].'/'.$result['image'];
                $result['image'] = $this->getImg($path) ;  
            }else{
                $path = '/static/image/category/no-avatar/no-avatar.png';
                $image = config('filesystems.disks')['public']['url'].$path;
                $result['image'] = $image;   
            }
        }
        return $result;
    }

    public function getAllCategory() {
        $result = $this->_model
            ->select(
                'categories.id',
                'categories.course_id',
                'categories.name',
                'categories.image',  
                'categories.maximum_student',
                'categories.start_day',
                'categories.description',
                'categories.id_teacher',
                'categories.end_day',
                DB::raw('COUNT(products.id) as amount_registed')
            )
            ->leftjoin('products', 'products.course_id', 'categories.course_id')
            ->orderBy('course_id', 'desc')
            ->groupBy('course_id')
            ->get();
        if ($result) {
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['image'])){
                    $path = '/static/image/category/'.$result[$i]['course_id'].'/'.$result[$i]['image'];
                    $result[$i]['image'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/category/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['image'] = $image;   
                }
            }
        }
        return $result;
    }

    public function getAllCategoryByTeacher($teacher_id)
    {
        $result = $this->_model
            ->select(
                'categories.id',
                'categories.course_id',
                'categories.name',
                'categories.image',  
                'categories.maximum_student',
                'categories.start_day',
                'categories.description',
                'categories.id_teacher',
                'categories.end_day',
                DB::raw('COUNT(products.id) as amount_registed')
            )
            ->leftjoin('products', 'products.course_id', 'categories.course_id')
            ->orderBy('course_id', 'desc')
            ->groupBy('course_id')
            ->where('id_teacher', $teacher_id)
            ->get();
        if ($result) {
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['image'])){
                    $path = '/static/image/category/'.$result[$i]['course_id'].'/'.$result[$i]['image'];
                    $result[$i]['image'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/category/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['image'] = $image;   
                }
            }
        }
        return $result;
    }

    public function getKPIBySalesman($salesman_id) {
        $result = DB::table('kpi')
        ->where('kpi.student_id', $salesman_id)
        ->orderByDesc('kpi_id')
        ->first();
        return $result;
    }

}