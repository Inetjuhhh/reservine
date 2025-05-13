<form method="GET" action="{{ $action }}" class="mb-4 flex items-center gap-2">
    <label for="date" class="text-white font-semibold">Filter by Date:</label>
    <input type="date" id="date" name="date" value="{{ $filterDate }}" class="text-black p-1 rounded">
    <input type="hidden" name="view" value="{{ $view }}">
    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Filter</button>
    <a href="{{ route($view === 'dashboard' ? 'reservation.index' : 'tables.of.today') }}"
       class="px-3 py-1 bg-gray-500 text-white rounded">Clear</a>
</form>
