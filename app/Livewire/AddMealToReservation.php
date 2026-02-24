<?php

namespace App\Livewire;

use App\Models\Meal;
use App\Models\Reservation;
use Livewire\Component;
use Livewire\Attributes\On;
// use Livewire\WithBrowserEvents;

class AddMealToReservation extends Component
{
    // use WithBrowserEvents;
    public $reservationId;
    public $meal;
    public $mealId;

    public function mount($reservationId, $meal)
    {
    }

    public function addMeal()
    {
        $this->validate([
            'reservationId' => 'required|exists:reservations,id',
        ]);

        $reservation = Reservation::find($this->reservationId);
        if ($reservation) {
            $meal = Meal::find($this->mealId);
            if ($meal) {
                $reservation->meals()->attach($meal);
                session()->flash('message', 'Meal added to reservation successfully.');
            } else {
                session()->flash('error', 'Meal not found.');
            }
        }
        else {
            session()->flash('error', 'Reservation not found.');
        }

        // $this->dispatch('$refresh')->self();
    }

    public function render()
    {
        dd($this->reservations);

        return view('livewire.add-meal-to-reservation',
        // [
        //     'meals' => $this->reservation->meals()->latest()->get(),
        // ]
    );    }
}
