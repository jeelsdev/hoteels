<div>
    <div class="mt-4 flex justify-start w-1/2 gap-5">
        <x-apps.input wire:model="date" type="date" wire:change="getDays()" class="max-w-40" />
        <x-apps.select wire:model="perPage" wire:change="getDays()" class="w-40">
            <option value="day">1 día</option>
            <option value="days">5 días</option>
            <option value="week">1 semana</option>
            <option value="month">Mes</option>
        </x-apps.select>
    </div>
    <div class="bg-white border rounded-lg px-6 py-8 mx-auto mt-8">
        <div class="flex justify-between mb-6">
            <h1 class="text-lg font-bold">Egresos</h1>
            <div class="text-gray-700 flex gap-5">
                <span>Desde: </span>
                <div class="text-gray-700 font-bold">01/05/2024</div>
                <span>Hasta: </span>
                <div class="text-gray-700 font-bold">05/05/2024</div>
            </div>
        </div>
        <div>
            <div class="grid grid-col-1 lg:grid-cols-3 gap-1 lg:gap-4">
                <div class="bg-gray-200 rounded-md py-3 pl-5 w-full ">
                    subTotal
                </div>
                <div class="bg-gray-200 rounded-md py-3 pl-5 w-full ">
                    IGV
                </div>
                <div class="bg-gray-200 rounded-md py-3 pl-5 w-full ">Total</div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <canvas id="lineChartExpenses"></canvas>
    </div>
</div>
