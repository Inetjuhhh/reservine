<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = \App\Models\Reservation::with('guest', 'table')
            ->whereDate('starts_at', '>=', Carbon::today())->get();
        return view('dashboard')->with('reservations', $reservations);
    }
}
