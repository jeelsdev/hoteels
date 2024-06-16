<div class="mb-5 grid grid-cols-1 lg:grid-cols-2">
    <livewire:admin.movement.expense.information /> 
    <div>
        <div>
            <livewire:admin.movement.expense.create />
        </div>
        <div>
            <div class="block justify-between items-center mt-4 rounded-sm p-5 sm:flex">
                <div class="mb-1 w-full">
                    <div class="block items-center sm:flex md:divide-x md:divide-gray-100">
                        <div class="relative mt-1 mr-2 w-full md:w-64 xl:w-96 mb-2 md:mb-0">
                            <x-apps.input wire:model.live="search" placeholder="Buscar por descrición">
                            </x-apps.input>
                        </div>
                        <div class="flex items-center justify-end gap-1">
                            <x-apps.input wire:model="date" type="date" wire:change="getDays()" class="w-40" />
                            <x-apps.select wire:model="perPage" wire:change="getDays()" class="w-40">
                                <option value="day">1 día</option>
                                <option value="days">5 días</option>
                                <option value="week">1 semana</option>
                                <option value="month">Mes</option>
                            </x-apps.select>
                        </div>
                    </div>
                </div>
            </div>
            <x-apps.table class="bg-white">
                <x-slot name="head">
                    <tr>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                            Fecha
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                            Descrición
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                            Monto
                        </th>
                        <th scope="col" class="p-4 lg:p-5 w-5">
                        </th>
                    </tr>
                </x-slot>
                @if ($expenses->isEmpty())
                    <tr>
                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5 text-center"
                            colspan="6">
                            No se encontraron resultados
                        </td>
                    </tr>
                @else
                    @foreach ($expenses as $expense)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-1 lg:px-5 lg:py-2 text-base font-medium text-gray-900 whitespace-nowrap">
                                {{ $expense->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-1 lg:px-5 lg:py-2 text-base font-medium text-gray-900 whitespace-nowrap">
                                {{ $expense->description }}
                            </td>
                            <td class="px-4 py-1 lg:px-5 lg:py-2 text-base font-medium text-gray-900 whitespace-nowrap">
                                {{ $expense->amount }}
                            </td>
                            <td class="px-4 py-1 lg:px-5 lg:py-2 space-x-2 whitespace-nowrap flex">
                                <button wire:click="$dispatch('editExpense', {id: {{ $expense->id }}})" class="block">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <button type="button">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </x-apps.table>
            <div class="mx-4 mt-5">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>
</div>
