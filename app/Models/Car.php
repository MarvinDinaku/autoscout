<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    // Car.php
    protected $fillable = [
        'brand',
        'model',
        'price',
        'engine_size',
        'registration_date',
        'description', // Add this line
    ];



    // Car.php
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
