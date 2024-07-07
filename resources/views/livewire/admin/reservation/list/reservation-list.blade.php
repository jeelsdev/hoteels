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
        <form method="post" class="flex gap-10 mb-5">
            <div>
                <x-label for="date" class="text-sm font-medium text-neutral-700">Desde</x-label>
                <x-apps.input type="date" name="date" wire:model="fromDate" label="Fecha" class="max-w-48" wire:change="updateData()" />
            </div>
            <div>
                <x-label for="date" class="text-sm font-medium text-neutral-700">Hasta</x-label>
                <x-apps.input type="date" name="date" wire:model="toDate" label="Fecha" class="max-w-48" wire:change="updateData()" />
            </div>
        </form>
        <x-apps.info-table>
            <x-slot:thead>
                <tr>
                    <th scope="col" class="py-1 text-center">N° De Reserva</th>
                    <th scope="col" class="py-1">Fecha de llegada</th>
                    <th scope="col" class="py-1">Fecha de salida</th>
                    <th scope="col" class="py-1">N° de Habitación</th>
                    <th scope="col" class="py-1">Huesped</th>
                    <th scope="col" class="py-1">Correo electronico</th>
                    <th scope="col" class="py-1">Estado</th>
                    <th scope="col" class="py-1 text-center">Reservación</th>
                    <th scope="col" class="py-1 text-center">Extras</th>
                    <th scope="col" class="py-1 text-center">Tours</th>
                </tr>
            </x-slot:thead>
            @if (count($reservationLists) > 0)
                @foreach ($reservationLists as $key => $reservation)
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap py-1 font-medium text-center">{{ $reservation->id }}</td>
                        <td class="whitespace-nowrap py-1">{{ getFormattedDate($reservation->entry_date, 'Y-m-d H:i')  }}</td>
                        <td class="whitespace-nowrap py-1">{{ getFormattedDate($reservation->exit_date, 'Y-m-d H:i') }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->room->code }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->users[0]->name }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->users[0]->email }}</td>
                        <td class="whitespace-nowrap py-1">{{ getEnumValue('Status', $reservation->status) }}</td>
                        <td class="whitespace-nowrap py-1 text-center">{{ $reservation->payment->total_reservation}}</td>
                        <td class="whitespace-nowrap py-1 text-center">{{ $reservation->payment->total_xtras }}</td>
                        <td class="whitespace-nowrap py-1 text-center">{{ $reservation->payment->total_tours }}</td>
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
        {{ $reservationLists->links() }}
    </div>
</div>
