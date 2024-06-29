<div class="max-w-6xl mb-5 m-auto">
    <div class="block justify-between items-center my-4 bg-white rounded-sm lg:p-5 sm:flex">
        <div class="mb-1 w-full grid grid-cols-1 lg:grid-cols-2 p-3 lg:p-0">
            <div>
                <strong>Habitación #{{ $code }}</strong>
                <div class="flex mt-5">
                    <b class="text-gray-700">Tipo de habitación:</b>
                    <span class="ml-2">{{ $roomType }}</span>
                </div>
                <div class="flex">
                    <b class="text-gray-700">Piso:</b>
                    <span class="ml-2">{{ $floor }}</span>
                </div>
                <div class="flex">
                    <b class="text-gray-700">descripción:</b>
                    <span class="ml-2">{{ $description }}</span>
                </div>
            </div>
            <div class="mt-5 lg:mt-0">
                @if ($status == 'occupied')
                    <div class="bg-orange-500 text-white p-3 rounded-lg text-center">
                        <strong>Estado:</strong>
                        <b class="uppercase">Ocupado</b>
                    </div>
                @else
                    <form method="post" class="w-full lg:w-1/2">
                        <div>
                            <x-apps.label for="status" class="text-gray-500">Estado</x-apps.label>
                            <x-apps.select wire:model="status" id="status" name="status" class="w-full">
                                <option value="available">Disponible</option>
                                <option value="clean">Limpieza</option>
                                <option value="maintenance">Mantenimiento</option>
                            </x-apps.select>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-apps.button wire:click="save" type="button">Actualizar</x-apps.button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-10">
        <div class="max-w-6xl mx-auto sm:pr-6 lg:pr-8">
            <div class="sm:rounded-lg flex justify-between">
                <h2 class="font-bold text-xl">Historial</h2>
            </div>
        </div>
        <div class="max-w-6xl mx-auto sm:pr-6 lg:pr-8 pt-10">
            <x-apps.info-table>
                <x-slot:thead>
                    <tr>
                        <th scope="col" class="px-6 py-1">Fecha creación</th>
                        <th scope="col" class="px-6 py-1">Estado</th>
                        <th scope="col" class="px-6 py-1">Desde</th>
                        <th scope="col" class="px-6 py-1">Hasta</th>
                    </tr>
                </x-slot:thead>
                @if (count($roomHistories) > 0)
                    @foreach ($roomHistories as $roomHistory)
                        <tr class="border-b border-neutral-200">
                            <td class="whitespace-nowrap px-6 py-1">{{ $roomHistory->created_at }}</td>
                            <td class="whitespace-nowrap px-6 py-1 capitalize">{{ __($roomHistory->status) }}</td>
                            <td class="whitespace-nowrap px-6 py-1">{{ $roomHistory->from }}</td>
                            <td class="whitespace-nowrap px-6 py-1">{{ $roomHistory->to }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap px-6"></td>
                        <td class="whitespace-nowrap px-6">----</td>
                        <td class="whitespace-nowrap px-6">----</td>
                        <td class="whitespace-nowrap px-6"></td>
                    </tr>
                @endif
            </x-apps.info-table>
        </div>
    </div>
</div>
