<?php

namespace App\Repositories\Area;

use App\Repositories\RepositoryEloquent;
use App\Models\Area;
use Illuminate\Support\Facades\DB;


class AreaRepositoryEloquent extends RepositoryEloquent implements AreaRepositoryInterface
{
    public function getModel()
    {
        return Area::class;
    }

    public function getAllArea() {
        $result = $this->_model
            ->select(
                'area_active.id',
                'area_active.area_id',
                'area_active.name',
                'area_active.created_at',
                'area_active.updated_at'
            )
            ->orderBy('area_id', 'desc')
            ->get();
        return $result;
    }
}