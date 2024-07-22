<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'offerId',
        'category_name',
        'title',
        'images',
        'quantity',
        'sold',
        'price',
        'unit',
        'moq',
        'rating',
    ];
}
