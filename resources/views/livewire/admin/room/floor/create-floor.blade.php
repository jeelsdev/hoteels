<div class="block justify-between items-center mx-4 mt-4 bg-white rounded-sm lg:p-5 sm:flex">
    <div class="mb-1 w-full">
        <x-apps.form submit="{{ $create?'save':'update' }}">
            <div maxWidth="2xl">
                <x-slot name="title">
                    {{ $create?'Agregar':'Editar' }} Nivel o Piso
                </x-slot>
                <x-slot name="content">
                    <div class="mt-4 text-sm text-gray-600">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="description" value="Descripción" />
                                <x-input id="description" type="text" class="mt-1 block w-full" wire:model="description"/>
                                <x-input-error for="description" class="mt-2" />
                            </div>
                            <div>
                                <x-label for="denomination" value="Denominación" />
                                <x-input id="denomination" type="number" class="mt-1 block w-full" wire:model="denomination"/>
                                <x-input-error for="denomination" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    @if ($create)
                        <x-button class="ml-2" wire:loading.attr="disabled" type="submit">
                            Agregar
                        </x-button>
                    @else
                        <x-apps.link href="{{ route('room.floor') }}" wire:loading.attr="disabled" class="mr-5">
                            Cancelar
                        </x-apps.link>
                        <x-button class="ml-2" wire:loading.attr="disabled" type="submit">
                            Actualizar
                        </x-button>
                    @endif
                </x-slot>
            </div>
        </x-apps.form>
    </div>
</div>
