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

                <livewire:components.reservation.tour />

                <livewire:components.reservation.comment comment="" />
                
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

                <livewire:components.reservation.status :total="0" :advance="0" :show="false"  />
                
                <livewire:components.reservation.extra />

            </div>
        </div>
</div>
</form>
</div>
