<div class="mb-5">
    <form wire:submit="save">
        <div class="flex justify-between items-center mx-4 mb-4">
            <div></div>
            <x-apps.button type="submit" class="flex px-16 py-1">
                <span class="text-xl">Guardar</span>
                <img src="{{ asset('images/svg/save.svg') }}" alt="Guardar" width="20" class="ml-8 text-white">
            </x-apps.button>
        </div>
        <div class="grid grid-cols-2 gap-5 bg-white p-4">
            <div class="col">
                <div class="border border-gray-300 rounded-sm p-4 bg-gray-100">
                    <h2 class="">Reserva #{{ $numberReservation }} - {{ $nights }} noches</h2>
                    <div class="flex justify-between gap-2 mt-3">
                        <div class="w-full">
                            <x-label for="start_date" value="Fecha de entrada" />
                            <x-input id="start_date" type="date" class="mt-1 block w-full" wire:model="start_date"
                                wire:change="calculateTotalPrice()" value="{{ $start_date }}" />
                            <x-input-error for="start_date" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-label for="end_date" value="Fecha de salida" />
                            <x-input id="end_date" type="date" class="mt-1 block w-full" wire:model="end_date"
                                wire:change="calculateTotalPrice()" value="{{ $end_date }}" />
                            <x-input-error for="end_date" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-label for="origin" value="Origen" />
                            <x-apps.select id="origin" class="mt-1 block w-full" wire:model="origin">
                                <option value="">Seleccionar origen</option>
                                @foreach ($origins as $origin)
                                    <option value="{{ $origin->value }}">{{ $origin->name }}</option>
                                @endforeach
                            </x-apps.select>
                            <x-input-error for="origin" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="border border-gray-300 rounded-sm p-4 mt-5 bg-gray-100">
                    <div class="flex justify-between">
                        <h2 class="">Habitación #{{ $roomCode }}</h2>
                        <button type="button" wire:click="$toggle('showRoom')">
                            @if ($showRoom)
                                <img src="{{ asset('images/svg/arrow-up.svg') }}" alt="Editar" width="20" />
                            @else
                                <img src="{{ asset('images/svg/arrow-down.svg') }}" alt="Cerrar" width="20" />
                            @endif
                        </button>
                    </div>
                    <div class="grid grid-cols-4 mt-5 transition-all duration-300 {{ $showRoom ? '' : 'hidden' }}">
                        <div class="col-span-1">
                            <span class="text-gray-500 text-sm">Tipo</span>
                            <p>{{ getEnumValue('RoomType', $roomType) }}</p>
                        </div>
                        <div class="col-span-1">
                            <span class="text-gray-500 text-sm">Piso</span>
                            <p>{{ $floor }}</p>
                        </div>
                        <div class="col-span-2">
                            <x-label for="price" value="Precio" />
                            <x-input id="price" type="number" class="mt-1 block w-full" wire:model.live="price"
                                min="0" max="100000" />
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="w-full overflow-x-auto">
                            <div class="relative right-0">
                                <ul class="flex justify-start gap-3 list-none rounded-lg">
                                    @foreach ($usersTotal as $key => $value)
                                        <li class="z-30 px-4 border border-gray-400 rounded-t-md hover:bg-gray-400 {{ $key == $showUser ? 'bg-gray-400 border-b-0' : 'bg-gray-100' }}"
                                            wire:click="showUserForKey({{ $key }})">
                                            <a class="z-30 flex items-center px-0 py-1 mb-0 transition-all ease-in-out border-0 rounded-lg cursor-pointer text-slate-700 bg-inherit"
                                                data-tab-target="" active role="tab" aria-selected="true">
                                                <img src="{{ asset('images/svg/user.svg') }}" alt="user"
                                                    width="25">
                                                <span>{{ $key }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="z-30 px-4 border border-gray-400 rounded-t-md hover:bg-gray-200 bg-gray-50"
                                        wire:click="addUser({{ $uI }})">
                                        <a class="z-30 flex items-center px-0 py-1 mb-0 transition-all ease-in-out border-0 rounded-lg cursor-pointer text-slate-700 bg-inherit"
                                            data-tab-target="" active role="tab" aria-selected="true">
                                            <img src="{{ asset('images/svg/add-user.svg') }}" alt="add user"
                                                width="25">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="border border-gray-400 py-10 px-8 bg-white">
                                @foreach ($usersTotal as $key => $user)
                                    <div class="grid grid-cols-2 gap-4 {{ $key !== $showUser ? 'hidden' : '' }}">
                                        <div class="w-full">
                                            <x-label for="usersTotal.{{ $key }}.documentType"
                                                value="Tipo de documento" />
                                            <x-apps.select id="usersTotal.{{ $key }}.documentType"
                                                class="chosen-select mt-1 block w-full"
                                                wire:model="usersTotal.{{ $key }}.documentType">
                                                <option>Seleccionar</option>
                                                <option value="DNI">DNI</option>
                                                <option value="PASSPORT">Pasaporte</option>
                                                <option value="OTHER">Otro</option>
                                            </x-apps.select>
                                            <x-input-error for="usersTotal.{{ $key }}.documentType"
                                                class="mt-2" />
                                        </div>
                                        <div>
                                            <x-label for="usersTotal.{{ $key }}.document"
                                                value="Documento" />
                                            <div class="flex relative">
                                                <x-input id="usersTotal.{{ $key }}.document" type="number"
                                                    class="mt-1 block w-full"
                                                    wire:model="usersTotal.{{ $key }}.document" />
                                                <button wire:click="findUser({{ $key }})" type="button"
                                                    class="absolute mt-1 right-2 top-3 bg-white">
                                                    <img src="{{ asset('images/svg/search.svg') }}" alt="search"
                                                        width="20" class="" />
                                                </button>
                                            </div>
                                            <x-input-error for="usersTotal.{{ $key }}.document"
                                                class="mt-2" />
                                        </div>
                                        <div>
                                            <x-label for="usersTotal.{{ $key }}.name" value="Nombre" />
                                            <x-input id="usersTotal.{{ $key }}.name" type="text"
                                                class="mt-1 block w-full"
                                                wire:model="usersTotal.{{ $key }}.name" />
                                            <x-input-error for="usersTotal.{{ $key }}.name"
                                                class="mt-2" />
                                        </div>
                                        <div>
                                            <x-label for="usersTotal.{{ $key }}.lastName"
                                                value="Apellidos" />
                                            <x-input id="usersTotal.{{ $key }}.lastName" type="text"
                                                class="mt-1 block w-full"
                                                wire:model="usersTotal.{{ $key }}.lastName" />
                                            <x-input-error for="usersTotal.{{ $key }}.lastName"
                                                class="mt-2" />
                                        </div>
                                        <div>
                                            <x-label for="usersTotal.{{ $key }}.email" value="Email" />
                                            <x-input id="usersTotal.{{ $key }}.email" type="email"
                                                class="mt-1 block w-full"
                                                wire:model="usersTotal.{{ $key }}.email" />
                                            <x-input-error for="usersTotal.{{ $key }}.email"
                                                class="mt-2" />
                                        </div>
                                        <div>
                                            <x-label for="usersTotal.{{ $key }}.phone" value="Telefono" />
                                            <x-input id="usersTotal.{{ $key }}.phone" type="text"
                                                class="mt-1 block w-full"
                                                wire:model="usersTotal.{{ $key }}.phone" />
                                            <x-input-error for="usersTotal.{{ $key }}.phone"
                                                class="mt-2" />
                                        </div>
                                        <div></div>
                                    </div>
                                    @if ($key !== 1)
                                        <div class="flex justify-end mt-5 {{ $key !== $showUser ? 'hidden' : '' }}">
                                            <button type="button" wire:click="removeUserTotal({{ $key }})">
                                                <img src="{{ asset('images/svg/tash.svg') }}" alt="Delete"
                                                    width="15">
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-gray-300 rounded-sm p-4 mt-5">
                    <div class="flex justify-between">
                        <h2 class="text-lg">Tours</h2>
                        <button type="button" class="mr-5 hover:text-stone-700"
                            wire:click="addTour({{ $tI }})">
                            <span class=" text-xs font-semibold pl-2.5 py-1">
                                Agregar tour
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-12 gap-2 mt-2">
                        @foreach ($inputTours as $key => $value)
                            <div class="col-span-4">
                                <x-apps.select id="toursTotal" class="mt-1 block w-full"
                                    wire:model="toursTotal.{{ $key }}{{ $value }}"
                                    wire:change="calculateTotalPrice()">
                                    <option value="">Seleccionar tour</option>
                                    @foreach ($tours as $tour)
                                        <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                                    @endforeach
                                </x-apps.select>
                            </div>
                            <div class="content_payment col-span-3">
                                <x-input id="toursPayment" type="number" class="mt-1 block w-full"
                                    wire:model.live="toursPayment.{{ $key }}{{ $value }}.amount"
                                    placeholder="Cantidad" wire:change="calculateTotalPrice()" />
                            </div>
                            <div class="content_payment col-span-3">
                                <x-input id="toursPayment" type="number" class="mt-1 block w-full"
                                    wire:model.live="toursPayment.{{ $key }}{{ $value }}.price"
                                    placeholder="Precio" wire:change="calculateTotalPrice()" />
                            </div>
                            <div class="content_payment col-span-1 flex flex-col-reverse justify-center items-center">
                                <x-label for="toursPayment.{{ $key }}{{ $value }}.paid"
                                    value="Pagado" />
                                <x-input id="toursPayment" type="checkbox" class="mt-1 block"
                                    wire:model.live="toursPayment.{{ $key }}{{ $value }}.paid" />
                            </div>
                            <button type="button" class="flex justify-center items-center col-span-1"
                                wire:click="removeInputTour({{ $key }},'{{ $key }}{{ $value }}')">
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
                <div class="border border-gray-300 rounded-sm p-4 mt-5">
                    <x-label for="comments" value="Comentarios" />
                    <x-apps.textarea wire:model="comments" />
                </div>
            </div>
            <div>
                <div class="border border-b-0 border-gray-300 rounded-sm p-4">
                    <div class="flex justify-between">
                        <h2 class="font-bold mb-4">RESUMEN</h2>
                    </div>
                    <div class="bg-white max-w-xl mx-auto">
                        <div class="">
                            <x-apps.table>
                                <x-slot:head>
                                    <tr>
                                        <th scope="col" class="px-6 py-4"></th>
                                        <th scope="col" class="px-6 py-4">Cantidad</th>
                                        <th scope="col" class="px-6 py-4">Deuda</th>
                                        <th scope="col" class="px-6 py-4">Total</th>
                                    </tr>
                                </x-slot>
                                <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">Reservación</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $nights }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        {{ $status == 'booking' ? $pending_payment : '' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $total_reservation }}</td>
                                </tr>
                                <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">Extras</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ count($xtrasPayment) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $debtXtra }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $total_xtras }}</td>
                                </tr>
                                <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">Tours</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ count($toursPayment) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $debtTour }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $total_tours }}</td>
                                </tr>
                            </x-apps.table>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 border border-gray-300">
                    @php
                        // Calculo de totales
                        $_Total = $total_reservation + $total_xtras + $total_tours;
                        $igv = $_Total * 0.18;
                        $subtotal = $_Total - $igv;

                        // Calculo de deudas
                        $debtReservation = $status == 'booking' ? $pending_payment : 0;
                        $debtTotal = $debtReservation + $debtXtra + $debtTour;
                    @endphp
                    <div class="pl-8 max-w-xl mx-auto py-3 flex justify-end">
                        <div class="">
                            <div class="grid grid-cols-2 mb-1">
                                <div class="text-gray-700 mr-2">Total en deudas:</div>
                                <div class="text-gray-700"><span>s/ </span>{{ $debtTotal }}</div>
                            </div>
                            <div class="grid grid-cols-2 mb-1">
                                <div class="text-gray-700 mr-2">Subtotal:</div>
                                <div class="text-gray-700"><span>s/ </span>{{ $subtotal }}</div>
                            </div>
                            <div class="grid grid-cols-2 mb-1">
                                <div class="text-gray-700 mr-2">IGV (18%):</div>
                                <div class="text-gray-700"><span>s/ </span>{{ $igv }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="text-gray-700 mr-2 font-bold text-2xl">Total:</div>
                                <div class="text-gray-700 font-bold text-xl"><span>s/ </span>{{ $_Total }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border border-gray-300 rounded-sm p-4 mt-5 bg-gray-100">
                    <x-label for="status" value="Estado" />
                    <x-apps.select id="status" class="mt-1 block w-full" wire:model="status"
                        wire:change="checkStatusPending()">
                        <option value="">Seleccionar estado</option>
                        @foreach ($statuses as $status)
                            @if ($status->value != 'pending')
                                <option value="{{ $status->value }}">{{ $status->name }}</option>
                            @endif
                        @endforeach
                    </x-apps.select>
                    <x-input-error for="status" class="mt-2" />
                    <div class="grid grid-cols-2 gap-5 mt-2">
                        <div class="content_payment {{ !$showAdvanceReservation ? 'hidden' : '' }}">
                            <x-label for="advance_reservation" value="Ingresar adelanto" />
                            <x-input id="advance_reservation" type="number" class="mt-1 block w-full"
                                wire:model.live="advance_reservation" min="1"
                                max="{{ $total_reservation }}" />
                            <x-input-error for="advance_reservation" class="mt-2" />
                        </div>
                        <div class="content_payment {{ !$showAdvanceReservation ? 'hidden' : '' }}">
                            <x-label for="pending_payment" value="Monto pendiente" class="text-gray-500" />
                            <x-input id="pending_payment" type="number" class="mt-1 block w-full"
                                wire:model="pending_payment" disabled />
                            <x-input-error for="pending_payment" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="border border-gray-300 rounded-sm p-4 mt-5">
                    <div class="flex justify-between">
                        <h2 class="text-lg">Extras</h2>
                        <button type="button" class="mr-5 hover:text-stone-700"
                            wire:click="addXtra({{ $xI }})">
                            <span class="text-xs font-semibold pl-2.5 py-1">
                                Agregar extra
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-12 gap-2 mt-2">
                        @foreach ($inputXtras as $key => $value)
                            <div class="col-span-4">
                                <x-apps.select id="xtras" class="mt-1 block w-full"
                                    wire:model="xtrasTotal.{{ $key }}{{ $value }}"
                                    wire:change="addXtraPayment('{{ $key }}{{ $value }}')">
                                    <option value="">Seleccionar extra</option>
                                    @foreach ($xtras as $xtra)
                                        <option value="{{ $xtra->id }}">{{ $xtra->name }}</option>
                                    @endforeach
                                </x-apps.select>
                            </div>
                            <div class="content_payment col-span-3">
                                <x-input id="xtrasPayment" type="number" class="mt-1 block w-full"
                                    wire:model.live="xtrasPayment.{{ $key }}{{ $value }}.amount"
                                    placeholder="Cantidad" />
                            </div>
                            <div class="content_payment col-span-3">
                                <x-input id="xtrasPayment" type="number" class="mt-1 block w-full"
                                    wire:model.live="xtrasPayment.{{ $key }}{{ $value }}.price"
                                    wire:change="calculateTotalPrice()" placeholder="Precio" />
                            </div>
                            <div class="content_payment col-span-1 flex flex-col-reverse justify-center items-center">
                                <x-label for="xtrasPayment.{{ $key }}{{ $value }}.paid"
                                    value="Pagado" />
                                <x-input id="xtrasPayment" type="checkbox" class="mt-1 block"
                                    wire:model.live="xtrasPayment.{{ $key }}{{ $value }}.paid" />
                            </div>
                            <button type="button" class="flex justify-center items-center col-span-1"
                                wire:click="removeInputXtra({{ $key }}, '{{ $key }}{{ $value }}')">
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
            </div>
        </div>
</div>
</form>
</div>
