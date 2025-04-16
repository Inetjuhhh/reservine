<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationMealIngredient extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reservationMeal() {
        return $this->belongsTo(ReservationMeal::class);
    }

    public function ingredient() {
        return $this->belongsTo(Ingredient::class);
    }
}
