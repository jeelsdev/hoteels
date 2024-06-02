<div class="mb-5 max-w-7xl mx-auto">
    <div class="lg:flex gap-5">
        <div class="block justify-between  mt-4 rounded-sm sm:flex w-full gap-5">
            <div class="mb-1 w-full bg-white">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-bold text-gray-900">Historial</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Nombre
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $user->name }} {{ $user->last_name }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ $user->document_type }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $user->document }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Email
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $user->email }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Teléfono
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $user->phone }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <div class="block justify-between  mt-4 rounded-sm sm:flex w-full gap-5">
            <div class="mb-1 w-full bg-white">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-bold text-gray-900">Información</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Total en reservaciones
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $information['total_reservations'] }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Total en extras
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $information['total_xtras'] }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Total en tours
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $information['total_tours'] }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Ultima reserva
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                2/06/24
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full">
        <div class="block justify-between items-center mt-4 bg-white rounded-sm lg:p-5 sm:flex">
            <div class="mb-1 w-full">
                <div class="block items-center sm:flex md:divide-x md:divide-gray-100">
                    <div class="relative mt-1 sm:w-64 xl:w-96">
                        <x-apps.input wire:model.live="search" placeholder="Buscar por nombre">
                        </x-apps.input>
                    </div>
                    <div class="flex items-center w-full sm:justify-end gap-5">
                    </div>
                </div>
            </div>
        </div>
        <x-apps.info-table>
            <x-slot:thead>
                <tr>
                    <th scope="col" class="py-1">N° De Reserva</th>
                    <th scope="col" class="py-1">Fecha de llegada</th>
                    <th scope="col" class="py-1">Fecha de salida</th>
                    <th scope="col" class="py-1">N° de Habitación</th>
                    <th scope="col" class="py-1">Status</th>
                    <th scope="col" class="py-1">Precio total de la habitación</th>
                    <th scope="col" class="py-1">Precio total de Extras</th>
                    <th scope="col" class="py-1">Precio total de Tours</th>
                    <th scope="col" class="py-1">Pendientes</th>
                </tr>
            </x-slot:thead>
            @if (count($histories) > 0)
                @foreach ($histories as $key => $history)
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap py-1 font-medium">{{ $history->id }}</td>
                        <td class="whitespace-nowrap py-1">{{ $history->entry_date }}</td>
                        <td class="whitespace-nowrap py-1">{{ $history->exit_date }}</td>
                        <td class="whitespace-nowrap py-1">{{ $history->room->code }}</td>
                        <td class="whitespace-nowrap py-1">{{ $history->status }}</td>
                        <td class="whitespace-nowrap py-1">{{ $history->payment->total_reservation }}</td>
                        <td class="whitespace-nowrap py-1">{{ $history->payment->total_xtras }}</td>
                        <td class="whitespace-nowrap py-1">{{ $history->payment->total_tours }}</td>
                        <td class="whitespace-nowrap py-1">{{ 1 }}</td>
                    </tr>
                @endforeach
            @else
                <tr class="border-b border-neutral-200">
                    <td class="whitespace-nowrap px-6 font-medium"></td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6">-- --</td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6"></td>
                    <td class="whitespace-nowrap px-6"></td>
                </tr>
            @endif
        </x-apps.info-table>
        <div class="mx-4 mt-5">
            {{-- {{ $histories->links() }} --}}
        </div>
    </div>
</div>
