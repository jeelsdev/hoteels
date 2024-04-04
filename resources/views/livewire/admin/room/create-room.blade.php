<form wire:submit="save" >
    <x-dialog-modal maxWidth="2xl" wire:model="open">
        <x-slot name="title">
            Crear reservación
        </x-slot>
        <x-slot name="content">
            <div class="mt-4 text-sm text-gray-600">
                <div class="w-full">
                    <x-label for="usersTotal" value="Usuario" />
                    <x-apps.select id="usersTotal" class="chosen-select mt-1 block w-full" wire:model="usersTotal.0">
                        <option value="">Tipo de habitación</option>
                        @foreach($roomTypes as $roomType)
                        <option value="{{ $roomType->id }}">{{ $roomType->description }}</option>
                        @endforeach
                    </x-apps.select>
                    <x-input-error for="user_id" class="mt-2" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label for="code" value="Código" />
                        <x-input id="code" type="text" class="mt-1 block w-full" wire:model="code"/>
                        <x-input-error for="code" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="floor" value="Piso" />
                        <x-input id="floor" type="text" class="mt-1 block w-full" wire:model="floor">
                        <x-input-error for="floor" class="mt-2" />
                    </div>
                    
                </div>
                <div class="pt-5">
                    <x-label for="description" value="Descripción" />
                    <x-apps.textarea wire:model="description" />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="resetInputs()" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-button class="ml-2" wire:loading.attr="disabled" type="submit">
                {{ __('Create') }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</form>

