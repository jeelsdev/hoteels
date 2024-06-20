<div>
    <div class="mt-4 flex justify-between md:justify-start md:w-1/2 gap-5">
        <x-apps.input wire:model="date" type="date" wire:change="getDays()" class="max-w-40" />
        <x-apps.select wire:model="dayRange" wire:change="getDays()" class="w-40">
            <option value="day">Diario</option>
            <option value="week">Semanal</option>
            <option value="month">Mensual</option>
            <option value="year">Anual</option>
        </x-apps.select>
    </div>
    <div class="bg-white border rounded-sm px-6 py-6 mx-auto mt-5">
        <div class="md:flex justify-between mb-4">
            <h1 class="text-lg font-bold">Egresos</h1>
            <div class="text-gray-700 flex gap-5">
                @if ($dayRange == 'day')
                    <span class="text-gray-400">Fecha</span>
                    <div class="text-gray-700 font-bold">{{ $startDay }}</div>
                @else
                    <span class="text-gray-400">Desde</span>
                    <div class="text-gray-700 font-bold">{{ $startDay }}</div>
                    <span class="text-gray-400">Hasta</span>
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
    <div class="bg-white mt-10 p-5">
        <canvas id="lineChartExpenses" class="w-full"></canvas>
    </div>
</div>
