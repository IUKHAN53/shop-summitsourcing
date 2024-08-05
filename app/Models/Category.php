<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'leaf', 'level', 'parent_id','alibaba_id','icon','pallet_id', 'is_top', 'is_featured'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeTop($query)
    {
        return $query->where('is_top', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getImageAttribute()
    {
        return $this->icon ? Storage::url($this->icon) : asset('assets/imgs/theme/icons/categories/'.$this->name.'.png');
    }
}
