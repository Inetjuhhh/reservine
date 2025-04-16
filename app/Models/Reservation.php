<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function guest() {
        return $this->belongsTo(Guest::class);
    }

    public function table() {
        return $this->belongsTo(Table::class);
    }

    public function meals() {
        return $this->belongsToMany(Meal::class, 'reservation_meal');
    }
}
