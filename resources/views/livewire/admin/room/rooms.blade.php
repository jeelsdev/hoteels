<div class="mb-5">
    <div class="max-w-full mx-auto sm:pr-6 lg:pr-8 py-4">
        <form method="post" class="flex justify-start gap-10 mb-5">
            <div>
                <x-apps.label for="room" class="text-gray-500">Buscar por código</x-apps.label>
                <x-apps.input wire:model.live="search" id="room" name="room" type="text" class="w-20" />
            </div>
            <div>
                <x-apps.label for="roomType" class="text-gray-500">Tipo</x-apps.label>
                <x-apps.select wire:model.live="roomType" id="roomType" name="roomType">
                    <option value="">Todos</option>
                    @foreach ($roomTypes as $roomType)
                        <option value="{{ $roomType->id}}">{{ $roomType->description }}</option>
                    @endforeach
                </x-apps.select>
            </div>
            <div>
                <x-apps.label for="status" class="text-gray-500">Estado</x-apps.label>
                <x-apps.select wire:model.live="status" id="status" name="status">
                    <option value="">Todos</option>
                    <option value="available">Disponible</option>
                    <option value="clean">Limpieza</option>
                    <option value="exit">Salida</option>
                </x-apps.select>
            </div>
        </form>
    </div>
    <div class="flex flex-wrap justify-start gap-4">
        @foreach ($rooms as $room)
            @php
                switch ($room->status) {
                    case 'available':
                        $stastus_bg = 'bg-green-700';
                        $status_txt = 'text-green-700';
                        $txt = 'Disponible';
                        break;
                    case 'clean':
                        $stastus_bg = 'bg-blue-500';
                        $status_txt = 'text-blue-500';
                        $txt = 'Limpieza';
                        break;
                    case 'exit':
                        $stastus_bg = 'bg-orange-500';
                        $status_txt = 'text-orange-500';
                        $txt = 'Salida';
                        $roomHistory = $room->roomHistories->last();
                        if ($roomHistory) {
                            $txtDescription = 'a las ' . $roomHistory->to->format('H:i') . ' de hoy';
                        }
                        break;
                    default:
                        $stastus_bg = 'bg-green-700';
                        $status_txt = 'text-green-700';
                        $txtDescription = 'Disponible';
                        break;
                }
            @endphp
            <div class="flex-shrink-0 h-40 w-48 relative overflow-hidden {{ $stastus_bg }} rounded-lg max-w-xs shadow-lg">
                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none"
                    style="transform: scale(1.5); opacity: 0.1;">
                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white" />
                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white" />
                </svg>
                <div class="flex {{ $room->status == 'occupied'?'justify-end':'justify-between' }} px-6 text-white pt-2">
                    @if ($room->status == 'available')
                        <button class="cursor-pointer z-10" wire:click="redirectReservation({{ $room->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </button>
                    @endif
                    <a href="{{ route('room.see', ['id'=>$room->id]) }}" class="cursor-pointer z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 w-4">
                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="relative text-white pt-6 px-6">
                    <span class="block opacity-75 -mb-1">{{ $room->roomType->description }}</span>
                    <span class="block font-semibold text-xl">#{{ $room->code }}</span>
                    <div class="">
                        <small class="bg-white rounded-md {{ $status_txt }} text-xs font-bold px-3 py-2 leading-none block w-full text-center">
                            {{ $txt }}
                            @if ($room->status == 'exit')
                                <small class="{{ $status_txt }} text-xs font-bold  block">{{ $txtDescription }}</small>
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
