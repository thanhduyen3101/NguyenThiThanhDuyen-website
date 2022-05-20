<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $table = "checkin_address";

    protected $fillable = [
        'checkin_id',
        'salesman_id',
        'lat',
        'long',
        'image'
    ];
}
