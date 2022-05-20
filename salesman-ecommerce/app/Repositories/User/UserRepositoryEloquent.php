<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB   ;


class UserRepositoryEloquent extends RepositoryEloquent implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUserByType($type) {
        $result = $this->_model
            ->select(
                'users.id',
                'users.user_id',
                'users.birthday',
                'users.sex',
                'users.address',
                'users.avatar',
                'users.tel',
                'users.email',
                'users.name',
                'users.admin',
                'users.type_id',
                'users.created_at',
            )
            ->where('type_id', $type)
            ->where('users.state', 1)
            ->orderBy('user_id', 'desc')
            ->get();
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['avatar'])){
                    $path = '/static/avatar/user/'.$result[$i]['user_id'].'/'.$result[$i]['avatar'];
                    $result[$i]['avatar'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/avatar/user/no-avatar/no-avatar.png';
                    $avatar = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['avatar'] = $avatar;   
                }
            }
        return $result;
    }

    public function getAllUserByTeacher($teacher_id) {
        $result = $this->_model
            ->select(
                'users.id',
                'users.user_id',
                'users.birthday',
                'users.sex',
                'users.address',
                'users.avatar',
                'users.tel',
                'users.email',
                'users.name',
                'users.admin',
                'users.type_id',
                'users.created_at',
            )
            ->where('type_id', 'STUDENT')
            ->where('users.state', 1)
            ->join('orders', function($query) use($teacher_id) {
                $query->on('orders.student_id', 'users.user_id')
                    ->join('categories', function($query2) use($teacher_id) {
                        $query2->on('categories.course_id', 'orders.course_id')
                            ->where('categories.id_teacher', $teacher_id);
                    });
            })
            ->orderBy('user_id', 'desc')
            ->groupBy('users.id')
            ->get();
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['avatar'])){
                    $path = '/static/avatar/user/'.$result[$i]['user_id'].'/'.$result[$i]['avatar'];
                    $result[$i]['avatar'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/avatar/user/no-avatar/no-avatar.png';
                    $avatar = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['avatar'] = $avatar;   
                }
            }
        return $result;
    }
    
    public function getLastUserId() {
        $result = DB::table('users')
        ->orderByDesc('user_id')
        ->first();
        return $result;
    }

    public function getUserById($id) {
        $result = DB::table('users')
        ->where('users.user_id', $id)
        ->first();
        return $result;
    }

    public function getUserByEmail($email) {
        $result = DB::table('users')
        ->where('users.email', $email)
        ->where('users.state', 1)
        ->first();
        return $result;
    }

    public function getUserByTel($tel) {
        $result = DB::table('users')
        ->where('users.tel', $tel)
        ->where('users.state', 1)
        ->first();
        return $result;
    }

    public function getAllUser() {
        $result = $this->_model
            ->select(
                'users.id',
                'users.user_id',
                'users.birthday',
                'users.sex',
                'users.address',
                'users.avatar',
                'users.tel',
                'users.email',
                'users.name',
                'users.admin',
                'users.type_id',
                'users.created_at',
            )
            ->where('users.state', 1)
            ->where('users.type_id', 'STUDENT')
            ->orderBy('user_id', 'desc')
            ->get();
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['avatar'])){
                    $path = '/static/avatar/user/'.$result[$i]['user_id'].'/'.$result[$i]['avatar'];
                    $result[$i]['avatar'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/avatar/user/no-avatar/no-avatar.png';
                    $avatar = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['avatar'] = $avatar;   
                }
            }
        return $result;
    }

    public function getAllAdmin() {
        $result = $this->_model
            ->select(
                'users.id',
                'users.user_id',
                'users.birthday',
                'users.sex',
                'users.address',
                'users.avatar',
                'users.tel',
                'users.email',
                'users.name',
                'users.admin',
                'users.type_id',
                'users.courses_id',
                'users.created_at',
            )
            ->where('type_id', 'ADM')
            ->where('admin', 0)
            ->where('users.state', 1)
            ->orderBy('user_id', 'desc')
            ->get();
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['avatar'])){
                    $path = '/static/avatar/user/'.$result[$i]['user_id'].'/'.$result[$i]['avatar'];
                    $result[$i]['avatar'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/avatar/user/no-avatar/no-avatar.png';
                    $avatar = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['avatar'] = $avatar;   
                }
            }
        return $result;
    }

    public function getAllSalesman() {
        $result = $this->_model
            ->select(
                'users.id',
                'users.user_id',
                'users.birthday',
                'users.sex',
                'users.address',
                'users.avatar',
                'users.tel',
                'users.email',
                'users.name',
                'users.admin',
                'users.type_id',
                'users.created_at',
            )
            ->where('type_id', 'STUDENT')
            ->where('users.state', 1)
            ->orderBy('user_id', 'desc')
            ->get();
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['avatar'])){
                    $path = '/static/avatar/user/'.$result[$i]['user_id'].'/'.$result[$i]['avatar'];
                    $result[$i]['avatar'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/avatar/user/no-avatar/no-avatar.png';
                    $avatar = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['avatar'] = $avatar;   
                }
            }
        return $result;
    }
}