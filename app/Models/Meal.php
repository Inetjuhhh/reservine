<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Meal extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $guarded = [];

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient')->withTimestamps();
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'meal_category')->withTimestamps();
    }

    public function subcategories() {
        return $this->belongsToMany(Subcategory::class, 'meal_subcategory')->withTimestamps();
    }

    public function reservations() {
        return $this->belongsToMany(Reservation::class, 'reservation_meal');
    }
}
