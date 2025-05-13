<x-app-layout>
    <x-slot name="header">
        {{-- <x-reservation-filter :filter-date="$filterDate" :view="dashboard" /> --}}

        <form method="GET" action="{{ route('reservations') }}" class="mb-4">
            <label for="date" class="text-white font-semibold mr-2">Filter by Date:</label>
            <input type="date" id="date" name="date" value="{{ $filterDate }}" class="text-black p-1 rounded">
            <button type="submit" class="ml-2 px-3 py-1 bg-blue-500 text-white rounded">Filter</button>
        </form>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Naam</th>
                        <th scope="col" class="px-6 py-3">Datum</th>
                        <th scope="col" class="px-6 py-3">Starttijd</th>
                        <th scope="col" class="px-6 py-3">Eindtijd</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tafel</th>
                    </tr>
                </thead>
                <tbody>
                    @if($reservations->isEmpty())
                        <li>No reservations found.</li>
                    @endif
                    @foreach($reservations as $reservation)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="text-white px-6 py-4">{{ $reservation->guest->name }}</td>
                            <td class="text-white px-6 py-4">{{ \Carbon\Carbon::parse($reservation->starts_at)->format('d-m-Y') }}</td>
                            <td class="text-white px-6 py-4">{{ \Carbon\Carbon::parse($reservation->starts_at)->roundMinute(15)->format('H:i') }}</td>
                            <td class="text-white px-6 py-4">{{ \Carbon\Carbon::parse($reservation->ends_at)->ceilMinute(15)->format('H:i') }}</td>
                            <td class="text-white px-6 py-4">{{ $reservation->status }}</td>
                            <td class="text-white px-6 py-4">
                                @livewire('reservation-table-selector', ['reservationId' => $reservation->id], key($reservation->id))
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
