<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="wrapper w-4/5 mx-auto mt-10">
        <div class="grid grid-cols-3 gap-4 justify-items-center">
            <h2 class="text-white text-3xl">Tafel {{ $table->number }} @dd( $reservation)</h2>
        </div>
    </div>

</x-app-layout>
