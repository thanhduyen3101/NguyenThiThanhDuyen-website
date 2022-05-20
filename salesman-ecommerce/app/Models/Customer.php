<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customer";

    protected $fillable = [
        'customer_id',
        'name',
        'owner',
        'phone',
        'address',
        'lat',
        'long',
        'area_id',
        'images'
    ];

    public $timestamps = false;
}
