<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangeStatusOfReservation extends Component
{
    public $status;
    public $reservationId;

    public function mount($reservationId, $status)
    {
        $this->reservationId = $reservationId;
        $this->status = $status;
    }

    public function save()
     {

        // $this->validate([
        //     'status' => ['required', Rule::in(['to arrive','open','payed','archived','cancelled'])],
        // ]);

        $reservation = Reservation::findOrFail($this->reservationId);


        $reservation->update([
            'status' => $this->status,
        ]);


        $reservation->refresh();


        $this->dispatch('refresh-page');
    }

    public function render()
    {
        return view('livewire.change-status-of-reservation');
    }
}
