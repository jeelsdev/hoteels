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
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $rDebt }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $rTotal }}</td>
                    </tr>
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Extras</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $extras }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $eDebt }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $eTotal }}</td>
                    </tr>
                    <tr class="border-b border-neutral-200">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Tours</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $tours }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $tDebt }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">{{ $tTotal }}</td>
                    </tr>
                </x-apps.table>
            </div>
        </div>
    </div>
    <div class="bg-gray-300 border border-gray-500">
        <div class="pl-8 max-w-xl mx-auto py-3 flex justify-end">
            <div class="">
                <div class="grid grid-cols-2 mb-1">
                    <div class="text-gray-700 mr-2">Total en deudas:</div>
                    <div class="text-gray-700"><span>s/ </span>{{ $totalDebt  }}</div>
                </div>
                <div class="grid grid-cols-2 mb-1">
                    <div class="text-gray-700 mr-2">Subtotal:</div>
                    <div class="text-gray-700"><span>s/ </span>{{ $totalTotal - ($totalTotal * 0.18) }}</div>
                </div>
                <div class="grid grid-cols-2 mb-1">
                    <div class="text-gray-700 mr-2">IGV (18%):</div>
                    <div class="text-gray-700"><span>s/ </span>{{ $totalTotal * 0.18 }}</div>
                </div>
                <div class="grid grid-cols-2">
                    <div class="text-gray-700 mr-2 font-bold text-2xl">Total:</div>
                    <div class="text-gray-700 font-bold text-xl"><span>s/ </span>{{ $totalTotal }}</div>
                </div>
            </div>
        </div>
    </div>
    <input
        type="hidden"
        name="price"
        value="{{ $price }}"
        wire:ignore />
</div>
