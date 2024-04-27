<form wire:submit="save" >
    <x-dialog-modal maxWidth="2xl" wire:model="open">
        <x-slot name="title">
            <div class="flex justify-between mb-3">
                <div class="flex">
                    <h2 class="{{ $createWithNewUser?'text-gray-500':'' }} cursor-pointer" wire:click="$set('createWithNewUser', false)">Crear reservación</h2>
                    <h2 class="{{ $createWithNewUser?'':'text-gray-500' }} ml-5 cursor-pointer" wire:click="showCreateWithNewUser()">Nuevo usuario</h2>
                </div>
                <button {{ $isFavorite?'':'disabled' }} class="p-1 border-none outline-none disabled:text-gray-500 hover:scale-[1.1] transition-transform" type="button" wire:click="addFavoriteUser()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 {{ $userFavorite?'text-yellow-900':'' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                </button>
            </div>
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
                    @if ($createWithNewUser)
                        <div>
                            <x-label for="name" value="Nombre" />
                            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name"/>
                            <x-input-error for="name" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="lastName" value="Apellidos" />
                            <x-input id="lastName" type="text" class="mt-1 block w-full" wire:model="lastName"/>
                            <x-input-error for="lastName" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="email" value="Email" />
                            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="email"/>
                            <x-input-error for="email" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="phone" value="Telefono" />
                            <x-input id="phone" type="number" class="mt-1 block w-full" wire:model="phone"/>
                            <x-input-error for="phone" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-label for="documentType" value="Tipo de documento" />
                            <x-apps.select id="documentType" class="chosen-select mt-1 block w-full" wire:model="documentType">
                                <option>Seleccionar</option>
                                <option value="DNI">DNI</option>
                                <option value="PASSPORT">Pasaporte</option>
                                <option value="OTHER">Otro</option>
                            </x-apps.select>
                            <x-input-error for="documentType" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="document" value="Documento" />
                            <x-input id="document" type="number" class="mt-1 block w-full" wire:model="document"/>
                            <x-input-error for="document" class="mt-2" />
                        </div>
                        <div></div>
                    @else
                        <div class="w-full">
                            <x-label for="usersTotal" value="Usuario" />
                            <x-apps.select id="usersTotal" class="chosen-select mt-1 block w-full" wire:model="usersTotal.0" wire:change="isFavoriteUser()">
                                <option value="">Seleccionar usuario</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </x-apps.select>
                            <x-input-error for="user_id" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-label for="documentType" value="Tipo de documento" />
                            <x-apps.select id="documentType" class="chosen-select mt-1 block w-full" wire:model="documentType">
                                <option>Seleccionar</option>
                                <option value="DNI">DNI</option>
                                <option value="PASSPORT">Pasaporte</option>
                                <option value="OTHER">Otro</option>
                            </x-apps.select>
                            <x-input-error for="documentType" class="mt-2" />
                        </div>
                        <div>
                            <x-label for="document" value="Documento" />
                            <x-input id="document" type="number" class="mt-1 block w-full" wire:model="document"/>
                            <x-input-error for="document" class="mt-2" />
                        </div>
                    @endif
                    <div>
                        <x-label for="origin" value="Origen" />
                        <x-apps.select id="origin" class="mt-1 block w-full" wire:model="origin">
                            <option value="">Seleccionar origen</option>
                            @foreach($origins as $origin)
                            <option value="{{ $origin->value }}">{{ $origin->name }}</option>
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
                                @if ($status->value != 'pending')
                                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                                @endif
                            @endforeach
                        </x-apps.select>
                        <x-input-error for="status" class="mt-2" />
                    </div>
                    <div class="content_payment {{ !$showAdvanceReservation?'hidden':'' }}">
                        <x-label for="advance_reservation" value="Ingresar adelanto" />
                        <x-input id="advance_reservation" type="number" class="mt-1 block w-full" wire:model.live="advance_reservation" min="1" max="{{ $total_reservation }}"/>
                        <x-input-error for="advance_reservation" class="mt-2" />
                    </div>
                    <div class="content_payment {{ !$showAdvanceReservation?'hidden':'' }}">
                        <x-label for="pending_payment" value="Monto pendiente" class="text-gray-500"/>
                        <x-input id="pending_payment" type="number" class="mt-1 block w-full" wire:model="pending_payment" disabled/>
                        <x-input-error for="pending_payment" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="price" value="Precio" />
                        <x-input id="price" type="number" class="mt-1 block w-full" wire:model.live="price" min="0" max="100000"/>
                    </div>
                    <div>
                        <x-label for="total" value="Total" />
                        <x-input id="total" type="number" class="mt-1 block w-full" wire:model="total_reservation" />
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
                    <div class="grid grid-cols-12">
                        @foreach ($inputUsers as $key => $value)
                            <x-apps.select id="xtras" class="mt-1 block w-full col-span-11" wire:model="usersTotal.{{ $value }}">
                                <option value="">Seleccionar usuario</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </x-apps.select>
                            <button type="button" class="flex justify-center items-center col-span-1" wire:click="removeInputUser({{ $key }}, {{ $value }})">
                                <img width="20px" src="{{ asset('images/svg/tash.svg') }}" alt="tash" />
                            </button>
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
                    <div class="grid grid-cols-12 gap-2 mt-2">
                        @foreach ($inputXtras as $key => $value)
                            <div class="col-span-6">
                                <x-apps.select id="xtras" class="mt-1 block w-full" wire:model="xtrasTotal.{{ $key }}{{ $value }}" wire:change="addXtraPayment('{{ $key }}{{ $value }}')">
                                    <option value="">Seleccionar extra</option>
                                    @foreach($xtras as $xtra)
                                    <option value="{{ $xtra->id }}">{{ $xtra->name }}</option>
                                    @endforeach
                                </x-apps.select>
                            </div>
                            <div class="content_payment col-span-5">
                                <x-input id="xtrasPayment" type="number" class="mt-1 block w-full" wire:model.live="xtrasPayment.{{ $key }}{{ $value }}"/>
                            </div>
                            <button type="button" class="flex justify-center items-center col-span-1" wire:click="removeInputXtra({{ $key }}, '{{ $key }}{{ $value }}')">
                                <img width="20px" src="{{ asset('images/svg/tash.svg') }}" alt="tash" />
                            </button>
                        @endforeach
                    </div>
                    @if ($xtrasTotal)
                        <div class="pt-5">
                            <p class="text-end mr-5">
                                <span class="text-sm font-semibold text-gray-500">Total extras:</span>
                                <span class="text-sm font-semibold">{{ $total_xtras }}</span>
                            </p>
                        </div>
                    @endif
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
                    <div class="grid grid-cols-12 gap-2 mt-2">
                        @foreach ($inputTours as $key => $value)
                        <div class="col-span-6">
                            <x-apps.select id="toursTotal" class="mt-1 block w-full" wire:model="toursTotal.{{ $key }}{{ $value }}" wire:change="addTourPayment('{{ $key }}{{ $value }}')">
                                <option value="">Seleccionar tour</option>
                                @foreach($tours as $tour)
                                <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                                @endforeach
                            </x-apps.select>
                        </div>
                        <div class="content_payment col-span-5">
                            <x-input id="toursPayment" type="number" class="mt-1 block w-full" wire:model.live="toursPayment.{{ $key }}{{ $value }}"/>
                        </div>
                        <button type="button" class="flex justify-center items-center col-span-1" wire:click="removeInputTour({{ $key }},'{{ $key }}{{ $value }}')">
                            <img width="20px" src="{{ asset('images/svg/tash.svg') }}" alt="tash" />
                        </button>
                        @endforeach
                    </div>
                    @if ($toursTotal)
                        <div class="pt-5">
                            <p class="text-end mr-5">
                                <span class="text-sm font-semibold text-gray-500">Total tours:</span>
                                <span class="text-sm font-semibold">{{ $total_tours }}</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="resetInputs()" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
            <x-button class="ml-2" wire:loading.attr="disabled" type="submit">
                Crear
            </x-button>
        </x-slot>

    </x-dialog-modal>
</form>
