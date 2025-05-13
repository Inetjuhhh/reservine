<div>
    <select wire:model="selectedTableId" class="text-black">
        <option value="">-- Select Table --</option>
        @foreach($availableTables as $table)
            <option value="{{ $table->id }}">Table {{ $table->number }}</option>
        @endforeach
    </select>
</div>
