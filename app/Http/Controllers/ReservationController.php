<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index(Request $request)
{
    $filterDate = $request->input('date');

    $query = Reservation::with(['guest', 'table']);

    if ($filterDate) {
        $query->whereDate('starts_at', $filterDate);
    }

    $reservations = $query->get();

    $tables = Table::all();
    $availableTablesByReservation = [];

    foreach ($reservations as $reservation) {
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

        $availableTablesByReservation[$reservation->id] = $tables->whereNotIn('id', $conflictingReservations)->values();
    }

    return view('dashboard', compact('reservations', 'availableTablesByReservation', 'filterDate'));
}


    // private function getFilteredReservations(?string $filterDate = null)
    // {
    // $query = Reservation::with(['guest', 'table']);

    // if ($filterDate) {
    //     $query->whereDate('starts_at', $filterDate);
    // }

    // $reservations = $query->get();
    // $tables = Table::all();

    // $availableTablesByReservation = [];

    // foreach ($reservations as $reservation) {
    //     $conflictingReservations = Reservation::where('id', '!=', $reservation->id)
    //         ->where(function ($query) use ($reservation) {
    //             $query->whereBetween('starts_at', [$reservation->starts_at, $reservation->ends_at])
    //                 ->orWhereBetween('ends_at', [$reservation->starts_at, $reservation->ends_at])
    //                 ->orWhere(function ($query) use ($reservation) {
    //                     $query->where('starts_at', '<=', $reservation->starts_at)
    //                           ->where('ends_at', '>=', $reservation->ends_at);
    //                 });
    //         })
    //         ->pluck('table_id');

    //     $availableTablesByReservation[$reservation->id] = $tables->whereNotIn('id', $conflictingReservations)->values();
    // }

    // return compact('reservations', 'availableTablesByReservation');
    // }
    // public function index()
    // {
    //     $data = $this->getFilteredReservations(); // no date filter
    //     return view('dashboard', $data + ['filterDate' => null]);
    // }

    // public function filter(Request $request)
    // {
    //     $filterDate = $request->input('date');
    //     $data = $this->getFilteredReservations($filterDate);
    //     return view('dashboard', $data + ['filterDate' => $filterDate]);
    // }

    // public function tablesOfToday()
    // {
    //     $today = now()->toDateString();
    //     $data = $this->getFilteredReservations($today);
    //     return view('reservations/tables-of-today', $data + ['filterDate' => $today]);
    // }



}
