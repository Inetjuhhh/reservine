<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReservationFilter extends Component
{
    public $filterDate;
    public $action;
    public $view;

    public function __construct($filterDate = null, $action = null, $view = null)
    {
        $this->filterDate = $filterDate;
        $this->action = $action ?? route('filterReservations');
        $this->view = $view ?? 'dashboard'; //
    }

    public function render()
    {
        return view('components.reservation-filter');
    }
}
