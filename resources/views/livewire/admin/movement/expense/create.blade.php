<div class="block justify-between items-center lg:mx-4 mt-4 bg-white rounded-sm p-5 sm:flex">
    <div class="mb-1 w-full">
        <x-apps.form submit="{{ $create?'save':'update' }}">
            <div maxWidth="2xl">
                <x-slot name="title">
                    {{ $create?'Agregar':'Editar' }} egreso
                </x-slot>
                <x-slot name="content">
                    <div class="mt-4 text-sm text-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label for="description" value="Descrición" />
                                <x-input id="description" type="text" class="mt-1 block w-full" wire:model="description"/>
                                <x-input-error for="description" class="mt-2" />
                            </div>
                            <div>
                                <x-label for="amount" value="Monto" />
                                <x-input id="amount" type="number" step="any" class="mt-1 block w-full" wire:model="amount"/>
                                <x-input-error for="amount" class="mt-2" />
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
                        <x-apps.link href="{{ route('movement.expenses') }}" wire:loading.attr="disabled" class="mr-5">
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
