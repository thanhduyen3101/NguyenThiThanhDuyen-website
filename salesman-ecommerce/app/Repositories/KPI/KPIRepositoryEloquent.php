<?php

namespace App\Repositories\KPI;

use App\Repositories\RepositoryEloquent;
use App\Models\KPI;
use Illuminate\Support\Facades\DB;


class KPIRepositoryEloquent extends RepositoryEloquent implements KPIRepositoryInterface
{
    public function getModel()
    {
        return KPI::class;
    }
    
    public function getLastKPIId() {
        $result = DB::table('kpi')
        ->orderByDesc('kpi_id')
        ->first();
        return $result;
    }

    public function getAllKPI() {
        $result = $this->_model
            ->select(
                'kpi.id',
                'kpi.kpi_id',
                'kpi.student_id',
                'users.name',
                'kpi.test_2',
                'kpi.total',
                'kpi.test_1',
                'kpi.created_at',
                'kpi.updated_at'
            )
            ->join('users', 'users.user_id', '=', 'kpi.student_id')
            ->orderBy('kpi_id', 'desc')
            ->get();
        return $result;
    }

    public function getKPIBySalesman($salesman_id) {
        $result = DB::table('kpi')
        ->where('kpi.salesman_id', $salesman_id)
        ->orderByDesc('kpi_id')
        ->get();
        return $result;
    }

    public function getKPI($student_id) {
        $result = DB::table('kpi')
        ->where('kpi.student_id', $student_id)
        ->whereMonth('kpi.created_at', date('m'))
        ->whereYear('kpi.created_at', date('Y'))
        ->orderByDesc('kpi_id')
        ->first();
        return $result;
    }

}