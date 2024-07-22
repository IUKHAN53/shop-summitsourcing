<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'offerId',
        'category_id',
        'title',
        'images',
        'quantity',
        'sold',
        'price',
        'unit',
        'moq',
        'rating',
    ];

    public function getCategoryAttribute()
    {
        return \App\Models\Category::query()->where('alibaba_id', $this->category_id)->first()->name ?? '';
    }

    public function getWidthAttribute()
    {
        $totalScore = 5;
        return ($this->rating / $totalScore) * 100;
    }



}
