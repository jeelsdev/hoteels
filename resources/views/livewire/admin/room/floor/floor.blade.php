<div class="mb-5 lg:flex">
    <div class="lg:w-2/3">
        <div class="block justify-between items-center mx-4 mt-4 bg-white rounded-sm lg:p-5 sm:flex">
            <div class="mb-1 w-full">
                <div class="block items-center sm:flex md:divide-x md:divide-gray-100">
                    <div class="relative mt-1 sm:w-64 xl:w-96">
                        <x-apps.input wire:model.live="search" placeholder="Buscar por nombre">
                        </x-apps.input>
                    </div>
                    <div class="flex items-center w-full sm:justify-end gap-5">
                    </div>
                </div>
            </div>
        </div>
        <x-apps.table>
            <x-slot name="head">
                <tr>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                        id
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                        Descripción
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                        Denominación
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                        Fecha de creación
                    </th>
                    <th scope="col" class="p-4 lg:p-5 w-5">
                    </th>
                </tr>
            </x-slot>
            @if ($floors->isEmpty())
                <tr>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5" colspan="6">
                        No se encontraron resultados
                    </td>
                </tr>
            @else
                @foreach ($floors as $floor)
                    <tr class="hover:bg-gray-100">
    
                        <td class="px-4 py-1 lg:px-5 lg:py-2 text-base font-medium text-gray-900 whitespace-nowrap">
                            {{ $floor->id }}
                        </td>
                        <td class="px-4 py-1 lg:px-5 lg:py-2 text-base font-medium text-gray-900 whitespace-nowrap">
                            {{ $floor->description }}
                        </td>
                        <td class="px-4 py-1 lg:px-5 lg:py-2 text-base font-medium text-gray-900 whitespace-nowrap">
                            {{ $floor->denomination }}
                        </td>
                        <td class="px-4 py-1 lg:px-5 lg:py-2 text-base font-medium text-gray-900 whitespace-nowrap">
                            {{ $floor->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-1 lg:px-5 lg:py-2 space-x-2 whitespace-nowrap flex">
                            <button wire:click="$dispatch('editFloor', {id: {{ $floor->id }}})" class="block">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            {{-- <button type="button">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button> --}}
                        </td>
                    </tr>
                @endforeach
            @endif
        </x-apps.table>
    </div>
    <div class="lg:w-1/3">
       <livewire:admin.room.floor.create-floor/>
    </div>
</div>
