<div class="border border-gray-500 rounded-sm p-4 mt-5 bg-gray-300">
    <x-label
        for="status"
        value="Estado" />
    <x-apps.select
        id="status"
        class="mt-1 block w-full"
        wire:model.live="status">
        <option value="">Seleccionar estado</option>
        @foreach ($enumsStatus as $enumStatus)
            @if ($enumStatus->value != 'pending')
                <option value="{{ $enumStatus->value }}">{{ $enumStatus->name }}</option>
            @endif
        @endforeach
    </x-apps.select>
    <x-input-error
        for="status"
        class="mt-2" />
    @if ($show)
        <div class="grid grid-cols-2 gap-5 mt-2">
            <div class="content_payment">
                <x-label
                    for="advance"
                    value="Ingresar adelanto" />
                <x-input
                    id="advance"
                    name="advance"
                    type="number"
                    step="any"
                    class="mt-1 block w-full"
                    wire:model.live="advance" />
                <x-input-error
                    for="advance"
                    class="mt-2" />
            </div>
            <div class="content_payment">
                <x-label
                    for="pending"
                    value="Monto pendiente"
                    class="text-gray-500" />
                <x-input
                    id="pending"
                    name="pending"
                    type="number"
                    step="any"
                    class="mt-1 block w-full"
                    wire:model="rDebt"
                    disabled />
                <x-input-error
                    for="pending"
                    class="mt-2" />
            </div>
        </div>
    @endif
</div>
