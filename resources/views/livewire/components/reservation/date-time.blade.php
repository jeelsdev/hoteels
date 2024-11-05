<div class="border border-gray-500 rounded-sm p-4 bg-gray-300">
    <div class="flex justify-between">
        <h3 class="font-semibold">Reserva #{{ $numberReservation }}<span class="ml-4">({{ $nights }} {{ $nights > 2 ? 'noches' : 'noche' }})</span></h3>
        <button type="button" wire:click="$toggle('showTimeSetting')">
            @if ($showTimeSetting)
                <img
                    src="{{ asset('images/svg/arrow-up.svg') }}"
                    alt="Editar"
                    width="20" />
            @else
                <img
                    src="{{ asset('images/svg/arrow-down.svg') }}"
                    alt="Cerrar"
                    width="20" />
            @endif
        </button>
    </div>
    <div class="md:flex md:justify-between gap-2 mt-3">
        <div class="w-full">
            <x-label
                for="startDate"
                value="Fecha de entrada" />
            <x-input
                id="startDate"
                type="date"
                class="mt-1 block w-full"
                wire:model="startDate"
                wire:change="calculate()" />
            <x-input-error
                for="startDate"
                class="mt-2" />
        </div>
        <div class="w-full">
            <x-label
                for="endDate"
                value="Fecha de salida" />
            <x-input
                id="endDate"
                type="date"
                class="mt-1 block w-full"
                wire:model="endDate"
                wire:change="calculate()" />
            <x-input-error
                for="endDate"
                class="mt-2" />
        </div>
        <div class="w-full">
            <x-label
                for="origin"
                value="Origen" />
            <x-apps.select
                id="origin"
                class="mt-1 block w-full"
                wire:model="origin">
                <option value="">Seleccionar origen</option>
                @foreach ($origins as $origin)
                    <option value="{{ $origin->value }}">{{ $origin->name }}</option>
                @endforeach
            </x-apps.select>
            <x-input-error
                for="origin"
                class="mt-2" />
        </div>
    </div>
    <div class="md:flex md:justify-between gap-2 mt-3 transition-all duration-300 {{ $showTimeSetting ? '' : 'hidden md:hidden' }}">
        <div class="w-full">
            <x-label
                for="startTime"
                value="Hora de entrada" />
            <x-input
                id="startTime"
                type="time"
                class="mt-1 block w-full"
                wire:model="startTime"
                wire:change="calculate()" />
            <x-input-error
                for="startTime"
                class="mt-2" />
        </div>
        <div class="w-full">
            <x-label
                for="endTime"
                value="Hora de salida" />
            <x-input
                id="endTime"
                type="time"
                class="mt-1 block w-full"
                wire:model="endTime"
                wire:change="calculate()" />
            <x-input-error
                for="endTime"
                class="mt-2" />
        </div>
    </div>
</div>
