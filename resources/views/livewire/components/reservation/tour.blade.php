<div class="border border-gray-300 rounded-sm p-4 mt-5">
    <div class="flex justify-between">
        <h2 class="text-lg font-semibold">Tours</h2>
        <button
            type="button"
            class="mr-5 hover:text-stone-700"
            wire:click="addTour">
            <span class=" text-xs font-semibold pl-2.5 py-1">
                Agregar tour
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
    </div>
    <div class="grid grid-cols-12 gap-2 mt-2">
        @foreach ($tours as $key => $tour)
            <div class="col-span-6 md:col-span-4">
                <x-apps.select
                    id="tour-{{ $key }}"
                    class="mt-1 block w-full"
                    wire:model="tours.{{ $key }}.id"
                    wire:change="setTour('{{ $key }}')">
                    <option value="">Seleccionar tour</option>
                    @foreach ($toursData as $tourData)
                        <option value="{{ $tourData->id }}">{{ $tourData->name }}</option>
                    @endforeach
                </x-apps.select>
                <x-input-error
                    for="tours.{{ $key }}.id"
                    class="mt-2" />
            </div>
            <div class="content_payment col-span-6 md:col-span-3">
                <x-input
                    id="price-{{ $key }}"
                    type="number"
                    step="any"
                    class="mt-1 block w-full"
                    wire:model.live="tours.{{ $key }}.price"
                    placeholder="Precio"
                    wire:change="calculatePrice()" />
                <x-input-error
                    for="tours.{{ $key }}.price"
                    class="mt-2" />
            </div>
            <div class="content_payment col-span-6 md:col-span-3">
                <x-input
                    id="payment-{{ $key }}"
                    type="number"
                    class="mt-1 block w-full"
                    wire:model.live="tours.{{ $key }}.quantity"
                    placeholder="Cantidad"
                    wire:change="calculatePrice()" />
                <x-input-error
                    for="tours.{{ $key }}.quantity"
                    class="mt-2" />
            </div>
            <div class="content_payment col-span-3 md:col-span-1 flex flex-col-reverse justify-center items-center">
                <x-label
                    for="tours.{{ $key }}.paid"
                    value="Pagado" />
                <x-input
                    id="paid-{{ $key }}"
                    type="checkbox"
                    class="mt-1 block"
                    wire:model.live="tours.{{ $key }}.paid" />
            </div>
            <button
                type="button"
                class="flex justify-center items-center col-span-3 md:col-span-1"
                wire:click="removeTour('{{ $key }}')">
                <img width="20px" src="{{ asset('images/svg/tash.svg') }}" alt="tash" />
            </button>
        @endforeach
    </div>
    @if (count($tours) > 0)
        <div class="pt-5">
            <div class="flex justify-between">
                <div class="text-start">
                </div>
                <div>
                    <span class="text-sm font-semibold text-gray-500">Total:</span>
                    <span class="text-sm font-semibold">{{ count($tours) }}</span>
                </div>
            </div>
        </div>
    @endif
</div>
