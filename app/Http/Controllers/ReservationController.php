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

    public function tablesOfToday()
    {
        $today = now()->toDateString();
        $tables = Table::all();
        $reservations = Reservation::whereDate('starts_at', $today)
            ->get();

        return view('reservations/tables-of-today')->with([
            'tables' => $tables,
            'today' => $today,
        ]);
    }

    public function show($tableId)
    {
        $table = Table::findOrFail($tableId);
        $today = Carbon::today()->toDateString();

        $reservation = Reservation::where('table_id', $tableId)
            ->whereDate('starts_at', $today)
            ->where('status', 'open')
            ->first();
        if (!$reservation) {
            $reservation = new Reservation();
            $reservation->table_id = $tableId;
            $reservation->starts_at = Carbon::now();
            $reservation->ends_at = Carbon::now()->addHours(2); 
            $reservation->status = 'open';
            $reservation->save();
            }
        return view('reservations.show', compact('table', 'reservation'));
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
