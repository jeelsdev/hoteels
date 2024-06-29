<div class="mb-5">
    <div class="max-w-full mx-auto sm:pr-6 lg:pr-8 py-4">
        <form method="post" class="flex justify-start gap-10 mb-5">
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
                    <option value="occupied">Ocupado</option>
                    <option value="maintenance">Mantenimiento</option>
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
                    case 'occupied':
                        $stastus_bg = 'bg-orange-500';
                        $status_txt = 'text-orange-500';
                        $txt = 'Ocupado';
                        break;
                    case 'maintenance':
                        $stastus_bg = 'bg-gray-500';
                        $status_txt = 'text-gray-500';
                        $txt = 'Mantenimiento';
                        break;
                    default:
                        $stastus_bg = 'bg-gray-500';
                        $status_txt = 'text-gray-500';
                        $txt = 'Mantenimiento';
                        break;
                }
            @endphp
            <div class="flex-shrink-0 h-36 w-48 relative overflow-hidden {{ $stastus_bg }} rounded-lg max-w-xs shadow-lg">
                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none"
                    style="transform: scale(1.5); opacity: 0.1;">
                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white" />
                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white" />
                </svg>
                <div class="flex {{ $room->status == 'occupied'?'justify-end':'justify-between' }} px-6 text-white pt-2">
                    @if ($room->status == 'available' || $room->status == 'maintenance')
                        <button class="cursor-pointer z-10" wire:click="setClean({{ $room->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 w-4">
                                <path fill-rule="evenodd" d="M20.599 1.5c-.376 0-.743.111-1.055.32l-5.08 3.385a18.747 18.747 0 0 0-3.471 2.987 10.04 10.04 0 0 1 4.815 4.815 18.748 18.748 0 0 0 2.987-3.472l3.386-5.079A1.902 1.902 0 0 0 20.599 1.5Zm-8.3 14.025a18.76 18.76 0 0 0 1.896-1.207 8.026 8.026 0 0 0-4.513-4.513A18.75 18.75 0 0 0 8.475 11.7l-.278.5a5.26 5.26 0 0 1 3.601 3.602l.502-.278ZM6.75 13.5A3.75 3.75 0 0 0 3 17.25a1.5 1.5 0 0 1-1.601 1.497.75.75 0 0 0-.7 1.123 5.25 5.25 0 0 0 9.8-2.62 3.75 3.75 0 0 0-3.75-3.75Z" clip-rule="evenodd" />
                              </svg>
                        </button>
                    @endif
                    @if ($room->status == 'clean' || $room->status == 'maintenance')
                        <button class="cursor-pointer z-10" wire:click="setAvailable({{ $room->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 w-4">
                                <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                    @if ($room->status == 'available' || $room->status == 'clean')
                        <button class="cursor-pointer z-10" wire:click="setMaintenance({{ $room->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 w-4">
                                <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                                <path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                                <path fill-rule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                              </svg>
                        </button>
                    @endif
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
                        <small class="bg-white rounded-md {{ $status_txt }} text-xs font-bold px-3 py-2 leading-none flex items-center justify-center w-full">{{ $txt }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
