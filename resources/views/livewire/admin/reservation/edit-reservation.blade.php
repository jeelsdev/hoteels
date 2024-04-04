<form wire:submit="save" >
    <x-dialog-modal maxWidth="2xl" wire:model="open">
        <x-slot name="title">
            Editar reservación
        </x-slot>
        <x-slot name="content">
            <div class="mt-4 text-sm text-gray-600">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label for="start_date" value="Fecha de entrada" />
                        <x-input id="start_date" type="date" class="mt-1 block w-full" wire:model="start_date" wire:change="calculateTotalPrice()"  value="{{ $start_date }}"/>
                        <x-input-error for="start_date" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="end_date" value="Fecha de salida" />
                        <x-input id="end_date" type="date" class="mt-1 block w-full" wire:model="end_date" wire:change="calculateTotalPrice()" value="{{ $end_date }}"/>
                        <x-input-error for="end_date" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <x-label for="usersTotal" value="Usuario" />
                        <x-apps.select id="usersTotal" class="chosen-select mt-1 block w-full" wire:model="usersTotal.0">
                            <option value="">Seleccionar usuario</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($open) {{ $user->id == $reservation->users[0]->id?'selected':'' }}  @endif>{{ $user->name }}</option>
                            @endforeach
                        </x-apps.select>
                        <x-input-error for="user_id" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-label for="origin" value="Origen" />
                        <x-apps.select id="origin" class="mt-1 block w-full" wire:model="origin">
                            <option value="">Seleccionar origen</option>
                            @foreach($origins as $origin)
                            <option value="{{ $origin->value }}" @if($open) {{ $origin->value == $reservation->origin?'selected':'' }}  @endif>{{ $origin->name }}</option>
                            @endforeach
                        </x-apps.select>
                        <x-input-error for="origin" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-label for="room_id" value="Habitación" />
                        <x-apps.select id="room_id" class="mt-1 block w-full" wire:model="room_id">
                            <option value="">Seleccionar habitación</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $room->id==$room_id?'selected':'' }}>{{ $room->code }}-{{ $room->roomType->description }}</option>
                            @endforeach
                        </x-apps.select>
                        <x-input-error for="room_id" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="status" value="Estado" />
                        <x-apps.select id="status" class="mt-1 block w-full" wire:model="status" wire:change="checkStatusPending()">
                            <option value="">Seleccionar estado</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->value }}" @if($open) {{ $status->value == $reservation->status?'selected':'' }}  @endif>{{ $status->name }}</option>
                            @endforeach
                        </x-apps.select>
                        <x-input-error for="status" class="mt-2" />
                    </div>
                    <div class="content_payment {{ !$showPendingPayment?'hidden':'' }}">
                    </div>
                    <div class="content_payment {{ !$showPendingPayment?'hidden':'' }}">
                        <x-label for="pending_payment" value="Indicar monto pendiente" />
                        <x-input id="pending_payment" type="number" class="mt-1 block w-full" wire:model="pending_payment"/>
                        <x-input-error for="pending_payment" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="price" value="Precio" />
                        <x-input id="price" type="number" class="mt-1 block w-full" wire:model.live="price" min="0" max="100000"/>
                    </div>
                    <div>
                        <x-label for="total" value="Total" />
                        <x-input id="total" type="number" class="mt-1 block w-full" wire:model="total"/>
                        <x-input-error for="total" class="mt-2" />
                    </div>
                </div>
                <div class="pt-5">
                    <x-label for="comments" value="Comentarios" />
                    <x-apps.textarea wire:model="comments" />
                </div>
                <div class="pt-5">
                    <div class="flex justify-between">
                        <h2 class="text-lg">Usuarios</h2>
                        <button type="button" class="mr-5 hover:text-stone-700" wire:click="addUser({{ $uI }})">
                            <span class="text-xs font-semibold pl-2.5 py-1">
                                Agregar usuario
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <div>
                        @foreach ($inputUsers as $key => $value)
                            <x-apps.select id="xtras" class="mt-1 block w-full" wire:model="usersTotal.{{ $value }}">
                                <option value="">Seleccionar usuario</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </x-apps.select>
                        @endforeach
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-between">
                        <h2 class="text-lg">Extras</h2>
                        <button type="button" class="mr-5 hover:text-stone-700" wire:click="addXtra({{ $xI }})">
                            <span class="text-xs font-semibold pl-2.5 py-1">
                                Agregar extra
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        @foreach ($inputXtras as $key => $value)
                            <div>
                                <x-apps.select id="xtras" class="mt-1 block w-full" wire:model="xtrasTotal.{{ $value }}" wire:change="addXtraPayment({{ $value }})">
                                    <option value="">Seleccionar extra</option>
                                    @foreach($xtras as $xtra)
                                    <option value="{{ $xtra->id }}">{{ $xtra->name }}</option>
                                    @endforeach
                                </x-apps.select>
                            </div>
                            <div class="content_payment">
                                <x-input id="xtrasPayment" type="number" class="mt-1 block w-full" wire:model.live="xtrasPayment.{{ $value }}"/>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-between">
                        <h2 class="text-lg">Tours</h2>
                        <button type="button" class="mr-5 hover:text-stone-700" wire:click="addTour({{ $tI }})">
                            <span class=" text-xs font-semibold pl-2.5 py-1">
                                Agregar tour
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        @foreach ($inputTours as $key => $value)
                        <div>
                            <x-apps.select id="toursTotal" class="mt-1 block w-full" wire:model="toursTotal.{{ $value }}" wire:change="addTourPayment({{ $value }})">
                                <option value="">Seleccionar tour</option>
                                @foreach($tours as $tour)
                                <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                                @endforeach
                            </x-apps.select>
                        </div>
                        <div class="content_payment">
                            <x-input id="toursPayment" type="number" class="mt-1 block w-full" wire:model.live="toursPayment.{{ $value }}"/>
                        </div>
                        @endforeach
                    </div>
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

