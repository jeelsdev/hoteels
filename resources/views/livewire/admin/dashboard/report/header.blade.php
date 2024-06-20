<div class="grid grid-cols-1 gap-6 mb-6 w-full xl:grid-cols-2 2xl:grid-cols-4">
    <div class="bg-white shadow-lg rounded-2xl p-4 ">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-gradient-to-br from-elf-green-800 to-elf-green-400 rounded-lg shadow-md shadow-gray-300">
                <img src="{{ asset('images/svg/banknotes.svg') }}" alt="bank" class="w-6">
            </div>
            <div class="flex-shrink-0 ml-3">
                <span class="text-2xl font-bold leading-none text-gray-900">s/ {{ $totalSales }}</span>
                <h3 class="text-base font-normal text-gray-500">Ventas del dia</h3>
            </div>
            @if ($sales >= 0)
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-green-500">
                    +{{ number_format($sales,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-up.svg') }}" alt="arrow up" class="w-6 text-green-600">
                </div>
            @else
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-red-500">
                    {{ number_format($sales,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-down.svg') }}" alt="arrow down" class="w-6 text-red-600">
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 ">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-gradient-to-br from-elf-green-800 to-elf-green-400 rounded-lg shadow-md shadow-gray-300">
                <img src="{{ asset('images/svg/globe.svg') }}" alt="globe" class="w-6">
            </div>
            <div class="flex-shrink-0 ml-3">
                <span class="text-2xl font-bold leading-none text-gray-900">s/ {{ $profits }}</span>
                <h3 class="text-base font-normal text-gray-500">Ganancias</h3>
            </div>
            @if ($earnings >= 0)
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-green-500">
                    +{{ number_format($earnings,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-up.svg') }}" alt="arrow up" class="w-6 text-green-600">
                </div>
            @else
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-red-500">
                    {{ number_format($earnings,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-down.svg') }}" alt="arrow up" class="w-6 text-red-600">
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 ">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-gradient-to-br from-elf-green-800 to-elf-green-400 rounded-lg shadow-md shadow-gray-300">
                <img src="{{ asset('images/svg/users.svg') }}" alt="user" class="w-6">
            </div>
            <div class="flex-shrink-0 ml-3">
                <span class="text-2xl font-bold leading-none text-gray-900">{{ $totalNewUsers }}</span>
                <h3 class="text-base font-normal text-gray-500">Usuarios nuevos</h3>
            </div>
            @if ($newUsers >= 0)
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-green-500">
                    +{{ number_format($newUsers,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-up.svg') }}" alt="arrow up" class="w-6 text-green-600">
                </div>
            @else
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-red-500">
                    {{ number_format($newUsers,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-down.svg') }}" alt="arrow up" class="w-6 text-red-600">
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 ">
        <div class="flex items-center">
            <div
                class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-gradient-to-br from-elf-green-800 to-elf-green-400 rounded-lg shadow-md shadow-gray-300">
                <img src="{{ asset('images/svg/shopping-cart.svg') }}" alt="shopping" class="w-6">
            </div>
            <div class="flex-shrink-0 ml-3">
                <span class="text-2xl font-bold leading-none text-gray-900">{{ $totalReservations }}</span>
                <h3 class="text-base font-normal text-gray-500">Reservaciones</h3>
            </div>
            @if ($reservations >= 0)
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-green-500">
                    +{{ number_format($reservations,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-up.svg') }}" alt="arrow up" class="w-6 text-green-600">
                </div>
            @else
                <div
                    class="flex flex-1 justify-end items-center ml-5 w-0 text-base font-bold text-red-500">
                    {{ number_format($reservations,0) }}%
                    <img src="{{ asset('images/svg/arrow-long-down.svg') }}" alt="arrow up" class="w-6 text-red-600">
                </div>
            @endif
        </div>
    </div>
</div>