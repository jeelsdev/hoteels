<div class="mb-5">
    <form wire:submit="save">
        <div class="flex justify-between items-center mx-4 mb-4">
            <div></div>
            <x-apps.button type="submit" class="px-16">
                <span class="text-xl">Guardar</span>
                <img src="{{ asset('images/svg/save.svg') }}" alt="Guardar" width="25" class="ml-4 text-white">
            </x-apps.button>
        </div>
        <div class="grid grid-cols-1 gap-2 bg-white p-4 lg:grid-cols-2 lg:gap-5">
            <div class="col">
                
                <livewire:components.reservation.date-time :date="$date" />

                <livewire:components.reservation.room :room="$room" />

                <livewire:components.reservation.guest />

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
                            <div class="col-span-6 md:col-span-4">
                                <x-apps.select id="toursTotal" class="mt-1 block w-full"
                                    wire:model="toursTotal.{{ $key }}{{ $value }}">
                                    <option value="">Seleccionar tour</option>
                                    @foreach ($tours as $tour)
                                        <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                                    @endforeach
                                </x-apps.select>
                                <x-input-error for="toursTotal.{{ $key }}{{ $value }}" class="mt-2" />
                            </div>
                            <div class="content_payment col-span-6 md:col-span-3">
                                <x-input id="toursPayment" type="number" class="mt-1 block w-full"
                                    wire:model.live="toursPayment.{{ $key }}{{ $value }}.amount"
                                    placeholder="Cantidad" wire:change="calculateTotalPrice()" />
                                <x-input-error for="toursPayment.{{ $key }}{{ $value }}.amount" class="mt-2" />
                            </div>
                            <div class="content_payment col-span-6 md:col-span-3">
                                <x-input id="toursPayment" type="number" step="any" class="mt-1 block w-full"
                                    wire:model.live="toursPayment.{{ $key }}{{ $value }}.price"
                                    placeholder="Precio" wire:change="calculateTotalPrice()" />
                                <x-input-error for="toursPayment.{{ $key }}{{ $value }}.price" class="mt-2" />
                            </div>
                            <div class="content_payment col-span-3 md:col-span-1 flex flex-col-reverse justify-center items-center">
                                <x-label for="toursPayment.{{ $key }}{{ $value }}.paid"
                                    value="Pagado" />
                                <x-input id="toursPayment" type="checkbox" class="mt-1 block"
                                    wire:model.live="toursPayment.{{ $key }}{{ $value }}.paid" />
                            </div>
                            <button type="button" class="flex justify-center items-center col-span-3 md:col-span-1"
                                wire:click="removeInputTour({{ $key }},'{{ $key }}{{ $value }}')">
                                <img width="20px" src="{{ asset('images/svg/tash.svg') }}" alt="tash" />
                            </button>
                        @endforeach
                    </div>
                    @if ($toursTotal)
                        <div class="pt-5">
                            <div class="flex justify-between">
                                <div class="text-start">
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-500">Total tours:</span>
                                    <span class="text-sm font-semibold">{{ $total_tours }}</span>
                                </div>
                            </div>
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
                                        <th scope="col" class="px-6 py-4">Deuda (s/)</th>
                                        <th scope="col" class="px-6 py-4">Total (s/)</th>
                                    </tr>
                                </x-slot>
                                <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">Reservación</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $nights }} noches</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $status=='booking' || $status=='confirmed'?$pending_payment:'' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $total_reservation }}</td>
                                </tr>
                                <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">Extras</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ count($xtrasPayment) }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $debtXtra }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ $total_xtras }}</td>
                                </tr>
                                <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">Tours</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">{{ count($toursPayment) }}</td>
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
                        $debtReservation = $status == 'booking'||$status=='confirmed' ? $pending_payment : 0;
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
                            <x-input id="advance_reservation" type="number" step="any" class="mt-1 block w-full"
                                wire:model.live="advance_reservation" min="1"
                                max="{{ $total_reservation }}" />
                            <x-input-error for="advance_reservation" class="mt-2" />
                        </div>
                        <div class="content_payment {{ !$showAdvanceReservation ? 'hidden' : '' }}">
                            <x-label for="pending_payment" value="Monto pendiente" class="text-gray-500" />
                            <x-input id="pending_payment" type="number" step="any" class="mt-1 block w-full"
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
                            <div class="col-span-6 md:col-span-4">
                                <x-apps.select id="xtras" class="mt-1 block w-full"
                                    wire:model="xtrasTotal.{{ $key }}{{ $value }}"
                                    wire:change="addXtraPayment('{{ $key }}{{ $value }}')">
                                    <option value="">Seleccionar extra</option>
                                    @foreach ($xtras as $xtra)
                                        <option value="{{ $xtra->id }}">{{ $xtra->name }}</option>
                                    @endforeach
                                </x-apps.select>
                                <x-input-error for="xtrasTotal.{{ $key }}{{ $value }}" class="mt-2" />
                            </div>
                            <div class="content_payment col-span-6 md:col-span-3">
                                <x-input id="xtrasPayment" type="number" class="mt-1 block w-full"
                                    wire:model.live="xtrasPayment.{{ $key }}{{ $value }}.amount"
                                    placeholder="Cantidad" />
                                <x-input-error for="xtrasPayment.{{ $key }}{{ $value }}.amount" class="mt-2" />
                            </div>
                            <div class="content_payment col-span-6 md:col-span-3">
                                <x-input id="xtrasPayment" type="number" step="any" class="mt-1 block w-full"
                                    wire:model.live="xtrasPayment.{{ $key }}{{ $value }}.price"
                                    wire:change="calculateTotalPrice()" placeholder="Precio" />
                                <x-input-error for="xtrasPayment.{{ $key }}{{ $value }}.price" class="mt-2" />
                            </div>
                            <div class="content_payment col-span-3 md:col-span-1 flex flex-col-reverse justify-center items-center">
                                <x-label for="xtrasPayment.{{ $key }}{{ $value }}.paid"
                                    value="Pagado" />
                                <x-input id="xtrasPayment" type="checkbox" class="mt-1 block"
                                    wire:model.live="xtrasPayment.{{ $key }}{{ $value }}.paid" />
                            </div>
                            <button type="button" class="flex justify-center items-center col-span-3 md:col-span-1"
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
