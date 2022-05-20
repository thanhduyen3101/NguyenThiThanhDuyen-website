<?php

namespace App\Repositories\Checkin;

use App\Repositories\RepositoryEloquent;
use App\Models\Checkin;
use Illuminate\Support\Facades\DB;


class CheckinRepositoryEloquent extends RepositoryEloquent implements CheckinRepositoryInterface
{
    public function getModel()
    {
        return Checkin::class;
    }
    
    public function getLastCheckinId() {
        $result = DB::table('checkin_address')
        ->orderByDesc('checkin_id')
        ->first();
        return $result;
    }

    public function getAllCheckin() {
        $result = $this->_model
            ->select(
                'checkin_address.id',
                'checkin_address.checkin_id',
                'checkin_address.salesman_id',
                'users.name',
                'checkin_address.lat',
                'checkin_address.long',
                'checkin_address.image',
                'checkin_address.created_at',
                'checkin_address.updated_at'
            )
            ->join('users', 'users.user_id', '=', 'checkin_address.salesman_id')
            ->orderBy('checkin_id', 'desc')
            ->get();
        if ($result) {
            for($i=0; $i<count($result); $i++){
                if(!empty($result[$i]['image'])){
                    $path = '/static/image/checkin/'.$result[$i]['checkin_id'].'/'.$result[$i]['image'];
                    $result[$i]['image'] = $this->getImg($path) ;  
                }else{
                    $path = '/static/image/checkin/no-avatar/no-avatar.png';
                    $image = config('filesystems.disks')['public']['url'].$path;
                    $result[$i]['image'] = $image;   
                }
            }
        }
        return $result;
    }

    public function getCheckinBySalesman($salesman_id) {
        $result = DB::table('checkin_address')
        ->where('checkin_address.salesman_id', $salesman_id)
        ->orderByDesc('checkin_id')
        ->get();
        return $result;
    }

}