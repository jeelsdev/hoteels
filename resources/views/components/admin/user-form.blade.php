<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="w-full">
        <x-label
            for="{{ $key }}-document-type"
            value="Tipo de documento" />
        <x-apps.select
            id="{{ $key }}-document-type"
            class="chosen-select mt-1 block w-full"
            wire:model="users.{{ $key }}.documentType">
                <option>Seleccionar</option>
                <option value="DNI">DNI</option>
                <option value="PASSPORT">Pasaporte</option>
                <option value="OTHER">Otro</option>
        </x-apps.select>
        <x-input-error
            for="users.{{ $key }}.documentType"
            class="mt-2" />
    </div>
    <div>
        <x-label
            for="{{ $key }}-document"
            value="Documento" />
        <div class="flex relative">
            <x-input
                id="{{ $key }}-document"
                type="number"
                class="mt-1 block w-full"
                wire:model="users.{{ $key }}.document" />
            <button
                wire:click="findUser('{{ $key }}')"
                type="button"
                class="absolute mt-1 right-2 top-3 bg-white">
                <img
                    src="{{ asset('images/svg/search.svg') }}"
                    alt="search"
                    width="20" />
            </button>
        </div>
        <x-input-error
            for="users.{{ $key }}.document"
            class="pl-1 mt-2" />
    </div>
    <div>
        <x-label
            for="{{ $key }}-name"
            value="Nombre" />
        <x-input
            id="{{ $key }}-name"
            type="text"
            class="mt-1 block w-full"
            wire:model="users.{{ $key }}.name" />
        <x-input-error
            for="users.{{ $key }}.name"
            class="mt-2" />
    </div>
    <div>
        <x-label
            for="{{ $key }}-lastName"
            value="Apellidos" />
        <x-input
            id="{{ $key }}-lastName"
            type="text"
            class="mt-1 block w-full"
            wire:model="users.{{ $key }}.lastName" />
        <x-input-error
            for="users.{{ $key }}.lastName"
            class="mt-2" />
    </div>
    <div>
        <x-label
            for="{{ $key }}-email"
            value="Email" />
        <x-input
            id="{{ $key }}-email"
            type="email"
            class="mt-1 block w-full"
            wire:model="users.{{ $key }}.email" />
        <x-input-error
            for="users.{{ $key }}.email"
            class="mt-2" />
    </div>
    <div>
        <x-label
            for="users.{{ $key }}.phone"
            value="Telefono" />
        <x-input
            id="users.{{ $key }}.phone"
            type="text"
            class="mt-1 block w-full"
            wire:model="users.{{ $key }}.phone" />
        <x-input-error
            for="users.{{ $key }}.phone"
            class="mt-2" />
    </div>
    <div></div>
</div>
