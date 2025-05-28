<x-app-layout>
    <x-slot name="header">
    </x-slot>


    <div class="wrapper w-4/5 mx-auto mt-10">
        <h2 class="text-3xl mb-5 text-white">Tafels vandaag</h2>
        <div class="grid grid-cols-3 gap-4 justify-items-center">
            @foreach($tables as $table)
                    <div class="border border-green-500 rounded-lg hover:bg-green-200">
                         <a class=" " href="{{ route('reservations.show', $table->id)}}">
                            <div class="w-[200px] h-[200px] bg-table bg-cover
                                @if($table->reservations->isEmpty())
                                    bg-green-500
                                @else
                                    @foreach($table->reservations as $reservation)
                                        @if(\Carbon\Carbon::parse($reservation->starts_at)->isToday())
                                            bg-yellow-400
                                        @else
                                            bg-green-500
                                        @endif
                                    @endforeach
                                @endif
                                        bg-center border border-green-500">
                                <img src="{{asset('storage/img/table.png')}}" alt="table-img" style="width: 200px;">
                                <p class="text-white text-center">Tafel {{$table->number}}</p>
                            </div>
                        </a>
                    </div>
            @endforeach
        </div>
    </div>

       {{-- <x-reservation-filter :filter-date="$filterDate" :view="tables-of-today" /> --}}

</x-app-layout>
