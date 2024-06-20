<div class="max-w-7xl mx-auto">
    <div class="mt-4 w-full flex justify-between gap-5">
        <div class="text-gray-600 font-bold">
            <span>{{ $startStringRangeDate }}</span>
            <span class="px-4 font-sans text-gray-500">al</span>
            <span>{{ $endStringRangeDate }}</span>
        </div>
        <x-apps.select wire:model="dayRange" wire:change="getDays()" class="w-40">
            <option value="week">Semanal</option>
            <option value="month">Mensual</option>
        </x-apps.select>
    </div>
    <div class="py-4 mx-auto mt-1 md:grid md:grid-cols-3 md:gap-5 lg:gap-16">
        <div class="p-6 bg-white shadow-sm rounded-sm">
            <dl class="space-y-2">
                <dt class="text-center text-sm font-medium text-gray-500 ">Total de la semana</dt>

                <dd class="text-center text-5xl font-light">{{ $income[0]->total?$income[0]->total:0 }}</dd>

                <dd class="flex items-center justify-center space-x-1 text-sm font-medium text-green-500">
                    <span>Ingresos</span>

                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17.25 15.25V6.75H8.75"></path>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 7L6.75 17.25"></path>
                    </svg>
                </dd>
            </dl>
        </div>

        <div class="p-6 bg-white shadow-sm rounded-sm mt-5 md:mt-0">
            <dl class="space-y-2">
                <dt class="text-center text-sm font-medium text-gray-500 ">Total de la semana</dt>

                <dd class="text-5xl text-center font-light">{{ $expenses[0]->total?$expenses[0]->total:0 }}</dd>

                <dd class="flex items-center justify-center space-x-1 text-sm font-medium text-red-500">
                    <span>Egresos</span>

                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17.25 8.75V17.25H8.75"></path>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 17L6.75 6.75"></path>
                    </svg>
                </dd>
            </dl>
        </div>

        <div class="p-6 bg-white shadow-sm rounded-sm mt-5 md:mt-0">
            <dl class="space-y-2 m-auto">
                <dt class="text-sm font-medium text-gray-500 text-center">Total de la semana</dt>

                <dd class="text-5xl font-light text-center">
                    {{ $income[0]->total - $expenses[0]->total }}
                </dd>

                <dd class="flex items-center justify-center space-x-1 text-sm font-medium text-yellow-700">
                    <span>Diferencia</span>
                    <img src="{{ asset('images/svg/money.svg') }}" alt="money" width="25px" style="color:yellow;">
                </dd>
            </dl>
        </div>
    </div>
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-white rounded-sm p-4 ">
            <canvas id="lineChartPanel" class="w-full"></canvas>
        </div>
        <div class="bg-white rounded-sm p-4 ">
            <canvas id="barChartPanel" class="w-full"></canvas>
        </div>
    </div>
</div>
