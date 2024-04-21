<div class="mb-5">
    <div class="block justify-between items-center mx-4 mt-4 bg-white rounded-sm lg:p-5 sm:flex">
        <div class="mb-1 w-full">
            <x-apps.form submit="save" >
                <div maxWidth="2xl">
                    <x-slot name="title">
                        Registrar usuario
                    </x-slot>
                    <x-slot name="content">
                        <div class="mt-4 text-sm text-gray-600">
                            <div class="grid grid-cols-2 gap-4 lg:grid-cols-3">
                                <div>
                                    <x-label for="name" value="Nombre" />
                                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name"/>
                                    <x-input-error for="name" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="surname" value="Apellido" />
                                    <x-input id="surname" type="text" class="mt-1 block w-full" wire:model="surname"/>
                                    <x-input-error for="surname" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="phone" value="Teléfono" />
                                    <x-input id="phone" type="text" class="mt-1 block w-full" wire:model="phone"/>
                                    <x-input-error for="phone" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="email" value="Email" />
                                    <x-input id="email" type="text" class="mt-1 block w-full" wire:model="email"/>
                                    <x-input-error for="email" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="documentType" value="Tipo de documento" />
                                    <x-apps.select id="documentType" class="chosen-select mt-1 block w-full" wire:model="documentType">
                                        <option value=""></option>
                                        @foreach($documentTypes as $key => $documentType)
                                        <option value="{{ $key }}">{{ $documentType }}</option>
                                        @endforeach
                                    </x-apps.select>
                                    <x-input-error for="documentType" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="document" value="Documento" />
                                    <x-input id="document" type="text" class="mt-1 block w-full" wire:model="document"/>
                                    <x-input-error for="document" class="mt-2" />
                                </div>
                            </div>
                            <div class="pt-5">
                                <x-label for="description" value="Descripción" />
                                <x-apps.textarea wire:model="description" />
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <x-apps.link href="{{ route('users.index') }}" wire:loading.attr="disabled" class="mr-5">
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


