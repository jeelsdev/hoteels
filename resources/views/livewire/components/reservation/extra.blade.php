<div class="border border-gray-300 rounded-sm p-4 mt-5">
    <div class="flex justify-between">
        <h2 class="text-lg">Extras</h2>
        <button
            type="button"
            class="mr-5 hover:text-stone-700"
            wire:click="addExtra()">
            <span class="text-xs font-semibold pl-2.5 py-1">
                Agregar extra
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
    </div>
    <div class="grid grid-cols-12 gap-2 mt-2">
        @foreach ($extras as $key => $extra)
            <div class="col-span-6 md:col-span-4">
                <x-apps.select
                    id="xtras"
                    class="mt-1 block w-full"
                    wire:model="extras.{{ $key }}.id"
                    wire:change="setExtra('{{ $key }}')">
                    <option value="">Seleccionar extra</option>
                    @foreach ($extrasData as $extraData)
                        <option value="{{ $extraData->id }}">{{ $extraData->name }}</option>
                    @endforeach
                </x-apps.select>
                <x-input-error
                    for="extras.{{ $key }}.id"
                    class="mt-2" />
            </div>
            <div class="content_payment col-span-6 md:col-span-3">
                <x-input
                    id="price-{{ $key }}"
                    type="number"
                    step="any"
                    class="mt-1 block w-full"
                    wire:model.live="extras.{{ $key }}.price"
                    wire:change="calculate('e-total')"
                    placeholder="Precio" />
                <x-input-error
                    for="extras.{{ $key }}.price"
                    class="mt-2" />
            </div>
            <div class="content_payment col-span-6 md:col-span-3">
                <x-input
                    id="quantity-{{ $key }}"
                    type="number"
                    class="mt-1 block w-full"
                    wire:model.live="extras.{{ $key }}.quantity"
                    wire:change="calculate('e-total')"
                    placeholder="Cantidad" />
                <x-input-error
                    for="extras.{{ $key }}.quantity"
                    class="mt-2" />
            </div>
            <div class="content_payment col-span-3 md:col-span-1 flex flex-col-reverse justify-center items-center">
                <x-label
                    for="extras.{{ $key }}.paid"
                    value="Pagado" />
                <x-input
                    id="paid-{{ $key }}"
                    type="checkbox"
                    class="mt-1 block"
                    wire:model.live="extras.{{ $key }}.paid"
                    wire:change="calculate('e-debt')" />
            </div>
            <button
                type="button"
                class="flex justify-center items-center col-span-3 md:col-span-1"
                wire:click="removeExtra('{{ $key }}')">
                <img
                    width="20px"
                    src="{{ asset('images/svg/tash.svg') }}"
                    alt="tash" />
            </button>
        @endforeach
    </div>
    @if (count($extras) > 0)
        <div class="pt-5">
            <p class="text-end mr-5">
                <span class="text-sm font-semibold text-gray-500">Total extras:</span>
                <span class="text-sm font-semibold">{{ count($extras) }}</span>
            </p>
        </div>
    @endif
</div>
