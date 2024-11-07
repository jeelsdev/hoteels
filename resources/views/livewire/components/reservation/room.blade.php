<div class="border border-gray-500 rounded-sm p-4 mt-5 bg-gray-300">
    <div class="flex justify-between">
        <h3 class="font-semibold">Habitación #{{ $roomCode }}</h3>
    </div>
    <div class="grid grid-cols-4 mt-5 transition-all duration-300">
        <div class="col-span-1">
            <span class="text-gray-600 text-sm">Tipo</span>
            <p>{{ $roomType }}</p>
        </div>
        <div class="col-span-1">
            <span class="text-gray-600 text-sm">Piso</span>
            <p>{{ $floor }}</p>
        </div>
        <div class="col-span-2">
            <x-label
                for="price"
                value="Precio"
                class="text-gray-600" />
            <x-input
                id="price"
                type="number"
                step="any"
                class="mt-1 block w-full"
                wire:model.live="price"
                min="0"
                max="100000" />
        </div>
    </div>
</div>
