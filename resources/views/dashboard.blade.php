<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Naam</th>
                        <th scope="col" class="px-6 py-3">Datum</th>
                        <th scope="col" class="px-6 py-3">Starttijd</th>
                        <th scope="col" class="px-6 py-3">Eindtijd</th>
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
                            <td class="text-white px-6 py-4">{{ $reservation->starts_at }}</td>
                            <td class="text-white px-6 py-4">{{ $reservation->ends_at }}</td>
                            <td class="text-white px-6 py-4">{{ $reservation->status }}</td>
                            <td class="text-white px-6 py-4">
                                <td class="text-white px-6 py-4">
                                    @livewire('reservation-table-selector', ['reservationId' => $reservation->id], key($reservation->id))
                                </td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
