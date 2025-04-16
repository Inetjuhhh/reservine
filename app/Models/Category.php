<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function meals() {
        return $this->belongsToMany(Meal::class, 'meal_category')->withTimestamps();
    }

    public function subcategories() {
        return $this->hasMany(Subcategory::class);
    }
}
