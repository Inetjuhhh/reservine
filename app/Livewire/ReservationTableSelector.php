<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Table;
use App\Models\Reservation;

class ReservationTableSelector extends Component
{
    public $reservationId;
    public $selectedTableId;
    public $availableTables = [];

    public function mount($reservationId)
    {
        $this->reservationId = $reservationId;
        $reservation = Reservation::with('table')->findOrFail($reservationId);

        $this->selectedTableId = $reservation->table?->id;

        $conflictingReservations = Reservation::where('id', '!=', $reservation->id)
            ->where(function ($query) use ($reservation) {
                $query->whereBetween('starts_at', [$reservation->starts_at, $reservation->ends_at])
                    ->orWhereBetween('ends_at', [$reservation->starts_at, $reservation->ends_at])
                    ->orWhere(function ($query) use ($reservation) {
                        $query->where('starts_at', '<=', $reservation->starts_at)
                              ->where('ends_at', '>=', $reservation->ends_at);
                    });
            })
            ->pluck('table_id');

        $this->availableTables = Table::whereNotIn('id', $conflictingReservations)->get();
    }

    public function updatedSelectedTableId($value)
    {
        $reservation = Reservation::find($this->reservationId);
        $reservation->table_id = $value;
        $reservation->save();
    }

    public function render()
    {
        return view('livewire.reservation-table-selector');
    }
}
?>
