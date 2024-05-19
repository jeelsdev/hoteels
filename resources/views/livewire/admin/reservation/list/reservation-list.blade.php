<div>
    <div class="max-w-7xl mx-auto sm:pr-6 lg:pr-8">
        <div class="sm:rounded-lg flex justify-between">
            <h2 class="font-bold text-xl">Listado de reservas</h2>
            <div>
                <small class="">Reservas del mes Mayo</small>
                <p class="text-center text-2xl">{{ 1 }}</p>
            </div>
        </div>
    </div>
    <div class="max-w-full mx-auto sm:pr-6 lg:pr-8 pt-10">
        <form method="post" class="flex gap-10 mb-5">
            <x-apps.input type="date" name="date" wire:model="date" label="Fecha" class="max-w-48"
                wire:change="daysRange()" />
            <x-apps.select name="type" label="Tipo" wire:model="dayRange" wire:change="daysRange()">
                <option value="days">5 días</option>
                <option value="week">1 semana</option>
                <option value="two-weeks">2 semanas</option>
                <option value="month">1 mes</option>
            </x-apps.select>
        </form>
        <x-apps.info-table>
            <x-slot:thead>
                <tr>
                    <th scope="col" class="py-1">N° De Reserva</th>
                    <th scope="col" class="py-1">Fecha de llegada</th>
                    <th scope="col" class="py-1">Fecha de salida</th>
                    <th scope="col" class="py-1">N° de Habitación</th>
                    <th scope="col" class="py-1">Huesped</th>
                    <th scope="col" class="py-1">Correo electronico</th>
                    <th scope="col" class="py-1">Status</th>
                    <th scope="col" class="py-1">Precio total de la habitación</th>
                    <th scope="col" class="py-1">Precio total de Extras</th>
                    <th scope="col" class="py-1">Precio total de Tours</th>
                    <th scope="col" class="py-1">Pendientes</th>
                </tr>
            </x-slot:thead>
            @if (count($reservationLists) > 0)
                @foreach ($reservationLists as $key => $reservation)
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap py-1 font-medium">{{ $reservation->id }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->entry_date }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->exit_date }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->room->code }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->users[0]->name }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->users[0]->email }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->status }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->payment->total_reservation }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->payment->total_xtras }}</td>
                        <td class="whitespace-nowrap py-1">{{ $reservation->payment->total_tours }}</td>
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
        {{ $reservationLists->links() }}
    </div>
</div>
