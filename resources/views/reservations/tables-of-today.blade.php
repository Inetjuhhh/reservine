<x-app-layout>
    <x-slot name="header">
    </x-slot>

        <div class="grid-container">
            <div class="grid-item">
                <img src="{{asset('storage/img/table.png')}}" alt="table-img" style="width: 368px;">
            </div>
        </div>

       {{-- <x-reservation-filter :filter-date="$filterDate" view="tables-of-today" /> --}}

</x-app-layout>
