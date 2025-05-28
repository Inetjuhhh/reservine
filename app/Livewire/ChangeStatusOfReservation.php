<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ChangeStatusOfReservation extends Component
{
    public $status;
    public $reservationId;

    public function mount($reservationId, $status)
    {
        $this->reservationId = $reservationId;
        $this->status = $status;
    }

    public function save(){
        $this->validate([
            'status' => 'required|in:to arrive,open,payed,archived,cancelled',
        ]);

        $reservation = Reservation::find($this->reservationId);
        if ($reservation) {
            $reservation->status = $this->status;
            $reservation->save();
            session()->flash('message', 'Reservation status updated successfully.');
        } else {
            session()->flash('error', 'Reservation not found.');
        }
    }

    public function render()
    {
        return view('livewire.change-status-of-reservation');
    }
}
