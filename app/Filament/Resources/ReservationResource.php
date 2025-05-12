<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\View\LegacyComponents\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('guest.name')
                    ->label('Gast naam')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('guest.email')
                    ->label('Gast email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Startdatum')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('Einddatum')
                    ->default(function($get){
                        return $get('start_date') ? $get('start_date')->addHours(3) : now()->addHours(3);
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('guest.name')
                    ->label('Gast naam')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Startdatum')
                    ->dateTime('d-m-Y H:i')
                    ->color(function($record, $state) {
                        return $record['starts_at']->isToday() ? 'success' : ($state->isPast() ? 'danger' : 'warning');
                        // dd($state, $record);
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_guests')
                    ->label('Aantal gasten')
                    ->sortable()
                    ->searchable(),
                SelectColumn::make('table.number')
                    ->label('Tafel')
                    ->sortable()
                    ->searchable()
                    ->options(function () {
                        return \App\Models\Table::all()->pluck('number', 'id');

                        //#TODO: only show tables that are not reserved for the selected date. something like:
                        // return \App\Models\Table::whereDoesntHave('reservations', function ($query) {
                        //     $query->where('starts_at', '<=', now()->addHours(3))
                        //         ->where('ends_at', '>=', now());
                        // })->pluck('number', 'id');
                    }),
                SelectColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->options([
                        'open' => 'Open',
                        'tobe' => 'Te komen',
                        'done' => 'Afgerond',
                        'archived' => 'Gearchiveerd',
                    ])
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            // ReservationResource\Widgets\CalendarWidget::class,
        ];
    }
}
