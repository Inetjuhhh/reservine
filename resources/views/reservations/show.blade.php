<x-app-layout>
    <x-slot name="header">
    </x-slot>



    <div class="wrapper w-4/5 mx-auto mt-10">
        <div class="">
            <h2 class="text-gray-500 text-3xl py-3 ">Tafel {{ $table->number }}</h2>
                @if (session('message'))
                    <x-flash-message></x-flash-message>
                @endif
            <p class="text-gray-500 italic">
                Tafel opgestart om {{ \Carbon\Carbon::parse($reservation->starts_at)->format('d-m-y H:i') }}
                @if($reservation->status === 'open')
                    en nog niet afgesloten.
                @elseif($reservation->status === 'payed')
                    en is betaald.
                @elseif($reservation->status === 'archived')
                    en is gearchiveerd.
                @elseif($reservation->status === 'cancelled')
                    en is geannuleerd.
                @endif
            </p>
            <div class="mt-5">
                <label for="status" class="text-gray-500">Status:</label>
                @livewire('change-status-of-reservation', ['reservationId' => $reservation->id, 'status' => $reservation->status], key($reservation->id))
            </div>
            <div class="mt-4">
                @if($reservation->status === 'payed')
                    <a href="{{ route('reservations.print', $reservation->id) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Print rekening
                    </a>
                @endif
            </div>

            <div class="mt-5 grid grid-cols-2 gap-4">
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h3 class="text-white text-2xl pb-5">Bestellingen:</h3>
                    @if($reservation->meals->isEmpty())
                        <p class="text-white">Er zijn nog geen bestellingen geplaatst.</p>
                    @else
                        <table class="w-full text-white rounded">
                            <thead>
                                <tr>
                                    <th class="text-left">Naam gerecht</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Prijs</th>
                                </tr>
                            @foreach($reservation->meals as $meal)
                                <tr class="rounded text-white
                                    @if($meal->status === 'prepared')
                                        bg-green-400
                                    @elseif($meal->status === 'served')
                                        bg-yellow-400
                                    @else
                                        bg-red-400
                                    @endif">
                                    <td class="p-2">{{ $meal->name }}</td>
                                    <td class="p-2">{{ $meal->status }}</td>
                                    <td class="p-2">€{{ number_format($meal->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                    <!-- i want a total of all the $meal->price together -->
                    @php
                        $total = $reservation->meals->sum('price');
                    @endphp
                    <p class="text-white mt-4">Totaal: €{{ number_format($total, 2) }}</p>
                </div>
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h3 class="text-white text-2xl pb-5">Maaltijden:</h3>
                    @foreach($meals as $meal)
                        @livewire('add-meal-to-reservation', ['meal' => $meal, 'mealId' => $meal->id, 'reservationId' => $reservation->id], key($meal->id))
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    window.addEventListener('refresh-page', () => {
        location.reload();
    });
</script>
