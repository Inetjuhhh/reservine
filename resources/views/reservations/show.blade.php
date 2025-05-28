<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="wrapper w-4/5 mx-auto mt-10">
        <div class="">
            <h2 class="text-white text-3xl">Tafel {{ $table->number }}</h2>
            <p class="text-white italic">
                Tafel opgestart om {{ \Carbon\Carbon::parse($reservation->starts_at)->format('d-m-y H:i') }}
            </p>
            <div class="mt-5">
                <label for="status" class="text-white">Status:</label>
                @livewire('change-status-of-reservation', ['reservationId' => $reservation->id, 'status' => $reservation->status], key($reservation->id))
            </div>
        </div>
    </div>
</x-app-layout>
