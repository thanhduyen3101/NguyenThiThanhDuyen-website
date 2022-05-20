<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function getUserByType($type);

    public function getAllUserByTeacher($teacher_id);

    public function getUserByEmail($email);

    public function getUserById($id);

    public function getUserByTel($tel);

    public function getAllUser();

    public function getAllAdmin();

    public function getLastUserId();

    public function getAllSalesman();
}