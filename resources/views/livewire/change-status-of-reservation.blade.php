<form wire:submit="save">
    @csrf
    <select wire:model="status" class="bg-gray-200 text-black p-2 rounded">
        <option value="to arrive">Nog niet aangekomen</option>
        <option value="open">Open</option>
        <option value="payed">Betaald</option>
        <option value="archived">Gearchiveerd</option>
        <option value="cancelled">Geannuleerd</option>
    </select>
    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
        Wijzig status</button>
</form>
