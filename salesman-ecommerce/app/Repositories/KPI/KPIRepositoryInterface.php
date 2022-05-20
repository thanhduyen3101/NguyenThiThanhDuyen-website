<?php
namespace App\Repositories\KPI;

interface KPIRepositoryInterface
{
    public function getLastKPIId();

    public function getAllKPI();

    public function getKPIBySalesman($salesman_id);
    // public function delete($salesman_id);
    // public function update($salesman_id);
    // public function create($salesman_id);

    public function getKPI($student_id);
}