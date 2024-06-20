<div class="mb-5">
    <div class="block justify-between items-center mx-4 mt-4 bg-white rounded-sm lg:p-5 sm:flex">
        <div class="mb-1 w-full">
            <x-apps.form submit="save" >
                <div maxWidth="2xl">
                    <x-slot name="title">
                        Editar habitación
                    </x-slot>
                    <x-slot name="content">
                        <div class="mt-4 text-sm text-gray-600">
                            <div class="w-full">
                                <x-label for="roomType" value="Tipo de habitación" />
                                <x-apps.select id="roomType" class="chosen-select mt-1 block w-full" wire:model="roomType">
                                    <option value=""></option>
                                    @foreach($roomTypes as $roomType)
                                        <option value="{{ $roomType->id }}">{{ $roomType->denomination }}</option>
                                    @endforeach
                                </x-apps.select>
                                <x-input-error for="roomType" class="mt-2" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label for="code" value="Código" />
                                    <x-input id="code" type="text" class="mt-1 block w-full" wire:model="code"/>
                                    <x-input-error for="code" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="floor" value="Piso" />
                                    <x-input id="floor" type="text" class="mt-1 block w-full" wire:model="floor"/>
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
                        <x-apps.link href="{{ route('room.index') }}" wire:loading.attr="disabled" class="mr-5">
                            Cancelar
                        </x-apps.link>
                        <x-button class="ml-2" wire:loading.attr="disabled" type="submit">
                            Guardar
                        </x-button>
                    </x-slot>
                </div>
            </x-apps.form>
        </div>
    </div>
    
</div>


