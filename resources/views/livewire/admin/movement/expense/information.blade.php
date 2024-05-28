<div>
    <script>
        window.expenses = @json($expenses);
    </script>
    <div class="mt-4 flex justify-start w-1/2 gap-5">
        <x-apps.input wire:model="date" type="date" wire:change="getDays()" class="max-w-40" />
        <x-apps.select wire:model="dayRange" wire:change="getDays()" class="w-40">
            <option value="day">Diario</option>
            <option value="week">Semanal</option>
            <option value="month">Mensual</option>
            <option value="year">Anual</option>
        </x-apps.select>
    </div>
    <div class="bg-white border rounded-lg px-6 py-8 mx-auto mt-8">
        <div class="flex justify-between mb-6">
            <h1 class="text-lg font-bold">Egresos</h1>
            <div class="text-gray-700 flex gap-5">
                @if ($dayRange == 'day')
                    <span>Fecha: </span>
                    <div class="text-gray-700 font-bold">{{ $startDay }}</div>
                @else
                    <span>Desde: </span>
                    <div class="text-gray-700 font-bold">{{ $startDay }}</div>
                    <span>Hasta: </span>
                    <div class="text-gray-700 font-bold">{{ $endDay }}</div>
                @endif
            </div>
        </div>
        <div>
            <div class="grid grid-col-1 lg:grid-cols-3 gap-1 lg:gap-4">
                <div class="bg-gray-200 rounded-md py-3 px-5 w-full flex justify-between">
                    <h3>SubTotal</h3>
                    <strong>{{ number_format($totalExpenses*0.18,2) }}</strong>
                </div>
                <div class="bg-gray-200 rounded-md py-3 px-5 w-full flex justify-between">
                    <h3>IGV</h3>
                    <strong>{{ number_format($totalExpenses - ($totalExpenses*0.18),2) }}</strong>
                </div>
                <div class="bg-gray-200 rounded-md py-3 px-5 w-full flex justify-between">
                    <h3>Total</h3>
                    <strong>{{ number_format($totalExpenses,2) }}</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <canvas id="lineChartExpenses"></canvas>
    </div>
</div>
