<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Guests;
use App\Models\Table;
use BcMath\Number;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    protected $events = [];
    public function fetchEvents(array $fetchInfo): array
    {
        $reservations = \App\Models\Reservation::with('guest')
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get();

        foreach($reservations as $reservation) {
            $this->events[] = [
                'id' => $reservation->id,
                'title' => $reservation->guest->name,
                'start' => $reservation->starts_at,
                'end' => $reservation->ends_at,
            ];
        }
        return $this->events;
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make()
            ->schema([
                TextInput::make('guest.name')
                    ->label('Gast naam')
                    ->required(),

                TextInput::make('guest.telephone')
                    ->label('Gast telefoonnummer')
                    ->required(),
            ]),
            Grid::make()
                ->schema([
                    TextInput::make('number_of_guests')
                        ->label('Aantal gasten')
                        ->numeric()
                        ->required(),

                    DateTimePicker::make('starts_at')
                        ->label('Begintijd')
                        ->required()
                        ->minDate(now())
                        ->afterStateUpdated(function ($state, callable $set) {
                            $get = Carbon::parse($state)->addHours(3);
                            $set('ends_at', $get->format('Y-m-d H:i'));
                        }),
            ]),
            TextInput::make('guest.email')
                ->label('Gast email (optioneel)'),

        ];
    }
}
