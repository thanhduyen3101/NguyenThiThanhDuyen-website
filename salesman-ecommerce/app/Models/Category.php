<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        'course_id',
        'name',
        'image',
        'maximum_student',
        'id_teacher',
        'description',
        'start_day',
        'end_day',
    ];
}
