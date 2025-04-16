<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationMeal extends Model
{
    use HasFactory;
    protected $table = 'reservation_meal';
    protected $guarded = [];

    public function reservation() {
        return $this->belongsTo(Reservation::class);
    }

    public function meal() {
        return $this->belongsTo(Meal::class);
    }

    public function modifications() {
        return $this->hasMany(ReservationMealIngredient::class);
    }
}
