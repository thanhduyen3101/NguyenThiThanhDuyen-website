<?php
namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function getAllCategory();

    public function getAllCategoryForStudent();

    public function getAllCategoryByTeacher($teacher_id);

    public function getLastCategoryId();

    public function findCategoryByStudentIdAndCourseId($course_id, $student_id);
}