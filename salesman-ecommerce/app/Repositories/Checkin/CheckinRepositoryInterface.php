<?php
namespace App\Repositories\Checkin;

interface CheckinRepositoryInterface
{
    public function getLastCheckinId();

    public function getAllCheckin();

    public function getCheckinBySalesman($salesman_id);
}