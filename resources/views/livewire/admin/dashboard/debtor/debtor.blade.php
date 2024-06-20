<div>
    <div class="max-w-4xl mx-auto sm:pr-6 lg:pr-8">
        <div class="sm:rounded-lg flex justify-between">
            <h2 class="font-bold text-xl">Informe de deudores</h2>
            <div>
                <small class="">Total pendientes de pago</small>
                <p class="text-center text-2xl">{{ count($debtLists) }}</p>
            </div>
        </div>
    </div>
    <div class="max-w-6xl mx-auto sm:pr-6 lg:pr-8 pt-10">
        <x-apps.info-table>
            <x-slot:thead>
                <tr>
                    <th scope="col" class="px-6 py-1">##</th>
                    <th scope="col" class="px-6 py-1">Fecha</th>
                    <th scope="col" class="px-6 py-1">Codigo</th>
                    <th scope="col" class="px-6 py-1">Huesped</th>
                    <th scope="col" class="px-6 py-1">Reserva</th>
                    <th scope="col" class="px-6 py-1">Extra</th>
                    <th scope="col" class="px-6 py-1">Tours</th>
                    <th scope="col" class="px-6 py-1">Total</th>
                </tr>
            </x-slot:thead>
            @if (count($debtLists) > 0)
                @foreach ($debtLists as $key => $debt)
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap px-6 py-1 font-medium">{{ $key+1 }}</td>
                        <td class="whitespace-nowrap px-6 py-1">{{ $debt['date'] }}</td>
                        <td class="whitespace-nowrap px-6 py-1">
                            <x-apps.link href="{{ route('reservation.edit', ['data'=>$debt['httpData']]) }}">
                            {{ $debt['code'] }}
                            </x-apps.link>
                        </td>
                        <td class="whitespace-nowrap px-6 py-1">{{ $debt['user'] }}</td>
                        <td class="whitespace-nowrap px-6 py-1">{{ $debt['booking'] }}</td>
                        <td class="whitespace-nowrap px-6 py-1">{{ $debt['xtra'] }}</td>
                        <td class="whitespace-nowrap px-6 py-1">{{ $debt['tour'] }}</td>
                        <td class="whitespace-nowrap px-6 py-1">{{ $debt['total'] }}</td>
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
                </tr>
            @endif
        </x-apps.info-table>
    </div>
</div>
