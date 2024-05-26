<div>
    <div class="max-w-4xl mx-auto sm:pr-6 lg:pr-8">
        <div class="sm:rounded-lg">
            <h2 class="font-bold text-xl">Ingresos diarios</h2>
        </div>
    </div>
    <div class="max-w-4xl mx-auto sm:pr-6 lg:pr-8 pt-10">
        <form method="post" class="flex gap-10">
            <x-apps.input type="date" name="date" wire:model="date" label="Fecha" class="max-w-48"
                wire:change="daysRange()" />
            <x-apps.select name="type" label="Tipo" wire:model="dayRange" wire:change="daysRange()">
                <option value="days">5 días</option>
                <option value="week">1 semana</option>
                <option value="two-weeks">2 semanas</option>
                <option value="month">1 mes</option>
            </x-apps.select>
        </form>
        <div class="sm:rounded-lg mb-20">
            @foreach ($dailyIncome as $daily)
                <div class="bg-white rounded-md border-2 border-gray-500 mt-10">
                    <div class="px-10 py-4 flex">
                        <h3>{{ $daily['date'] }}</h3>
                        @if (!$daily['close'])
                            <small class="text-xs px-1 ml-5 bg-yellow-300 border-t inline border-b border-yellow-500 text-yellow-900 rounded-md">Todavía falta cerrar el día</small>
                        @endif
                    </div>
                    <div class="flex pb-4 mx-3 gap-5">
                        <div class="bg-gray-200 rounded-md py-3 pl-5 w-full">
                            <small class="text-gray-500">Extras</small>
                            <p>s/ {{ $daily['xtras'] }}</p>
                        </div>
                        <div class="bg-gray-200 rounded-md py-3 pl-5 w-full">
                            <small class="text-gray-500">Tours</small>
                            <p>s/ {{ $daily['tours'] }}</p>
                        </div>
                        <div class="bg-gray-200 rounded-md py-3 pl-5 w-full">
                            <small class="text-gray-500">Reservaciones</small>
                            <p>s/ {{ $daily['total'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
