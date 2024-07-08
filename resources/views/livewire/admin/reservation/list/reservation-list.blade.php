<div>
    <div class="max-w-7xl mx-auto sm:pr-6 lg:pr-8">
        <div class="sm:rounded-lg flex justify-between">
            <h2 class="font-bold text-xl">Listado de reservas</h2>
            <div>
                <small class="">Total de reservas</small>
                <p class="text-center text-2xl">{{ $total }}</p>
            </div>
        </div>
    </div>
    <div class="max-w-full mx-auto sm:pr-6 lg:pr-8 pt-10">
        <div class="flex gap-10 mb-5 justify-between">
            <div>
                <x-label for="search" class="text-sm font-medium text-neutral-700">Buscar por código</x-label>
                <x-apps.input type="text" name="search" wire:model.live="search" label="Buscar" class="max-w-60"
                    wire:change="updateData()" />
            </div>
            <div class="flex gap-5">
                <div>
                    <x-label for="date" class="text-sm font-medium text-neutral-700">Desde</x-label>
                    <x-apps.input type="date" name="date" wire:model="fromDate" label="Fecha" class="max-w-48"
                        wire:change="updateData()" />
                </div>
                <div>
                    <x-label for="date" class="text-sm font-medium text-neutral-700">Hasta</x-label>
                    <x-apps.input type="date" name="date" wire:model="toDate" label="Fecha" class="max-w-48"
                        wire:change="updateData()" />
                </div>
            </div>
        </div>
        <x-apps.info-table>
            <x-slot:thead>
                <tr>
                    <th scope="col" class="py-1 text-center">Código de reserva</th>
                    <th scope="col" class="py-1">Fecha de llegada</th>
                    <th scope="col" class="py-1">Fecha de salida</th>
                    <th scope="col" class="py-1">N° de Habitación</th>
                    <th scope="col" class="py-1">Huesped</th>
                    <th scope="col" class="py-1">Correo electronico</th>
                    <th scope="col" class="py-1">Estado</th>
                    <th scope="col" class="py-1 text-center">Reservación</th>
                    <th scope="col" class="py-1 text-center">Extras</th>
                    <th scope="col" class="py-1 text-center">Tours</th>
                    <th scope="col" class="py-1 text-center"></th>
                </tr>
            </x-slot:thead>
            @if (count($reservationLists) > 0)
                @foreach ($reservationLists as $key => $reservation)
                    @php
                        $parts = explode('-', $reservation->reservation_code);
                    @endphp
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap py-1 font-medium text-center">{{ $parts[0] . '-' . $parts[1] }}</td>
                        <td class="whitespace-nowrap py-1">{{ getFormattedDate($reservation->entry_date, 'Y-m-d H:i') }}
                        </td>
                        <td class="whitespace-nowrap py-1">{{ getFormattedDate($reservation->exit_date, 'Y-m-d H:i') }}
                        </td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->room->code }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->users[0]->name }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->users[0]->email }}</td>
                        <td class="whitespace-nowrap py-1">{{ getEnumValue('Status', $reservation->status) }}</td>
                        <td class="whitespace-nowrap py-1 text-center">{{ $reservation->payment->total_reservation }}
                        </td>
                        <td class="whitespace-nowrap py-1 text-center">{{ $reservation->payment->total_xtras }}</td>
                        <td class="whitespace-nowrap py-1 text-center">{{ $reservation->payment->total_tours }}</td>
                        <td class="whitespace-nowrap py-1 text-center flex justify-around gap-2">
                            <a href="{{ route('reservation.edit', ['data' => http_build_query(['resource' => $reservation->room_id, 'reservation' => $reservation->id])]) }}"
                                class="text-blue-500 hover:text-blue-700 min-w-4">
                                <img src="{{ asset('images/svg/edit.svg') }}" alt="edit" width="15">
                            </a>
                            <button wire:click="openModalD({{ $reservation->id }})" class="min-w-4">
                                <img src="{{ asset('images/svg/tash.svg') }}" alt="tash" width="15">
                            </button>
                        </td>
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
                    <td class="whitespace-nowrap px-6"></td>
                </tr>
            @endif
        </x-apps.info-table>
        {{ $reservationLists->links() }}
    </div>
    @if ($openModalDelete)
        <x-apps.confirm-modal-delete>
            <x-slot name="content">
                <p class="text-sm text-gray-700 mt-1">
                    ¿Estás seguro de eliminar esta reserva?
                </p>
            </x-slot>
            <x-slot name="wireConfirm">
                reservationDelete({{ $reservationModalId }})
            </x-slot>
            <x-slot name="wireCancel">
                openModalDelete
            </x-slot>
        </x-apps.confirm-modal-delete>
    @endif
</div>
