<div class="">
    <div
        class="block justify-between items-center p-4 mx-4 mt-4 mb-6 bg-white rounded-2xl shadow-xl shadow-gray-200 lg:p-5 sm:flex">
        <div class="mb-1 w-full">
            <div class="block items-center sm:flex md:divide-x md:divide-gray-100">
                    <div class="relative mt-1 sm:w-64 xl:w-96">
                        <input type="text" name="text" id="products-search" wire:model.live="search"
                            class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-2 focus:ring-fuchsia-50 focus:border-fuchsia-300 block w-full p-2.5"
                            placeholder="Buscar habitaciones por código">
                    </div>
                <div class="flex items-center w-full sm:justify-end">
                    <div class="hidden pl-2 space-x-1 md:flex">
                        <a href="#"
                            class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                    <button type="button" wire:click="dispatchOpenModal()"
                        class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-gradient-to-br from-pink-500 to-voilet-500 sm:ml-auto shadow-md shadow-gray-300 hover:scale-[1.02] transition-transform">
                        <svg class="mr-2 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Craer habitación
                    </button>
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
                    Nombre
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                    Tipo de documento
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                    Documento
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                    Teléfono
                </th>
                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase lg:p-5">
                    Email
                </th>
                <th scope="col" class="p-4 lg:p-5 w-5">
                </th>
            </tr>
        </x-slot>
        @if ($users->isEmpty())
            <tr>
                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5" colspan="6">
                    No se encontraron habitaciones.
                </td>
            </tr>
        @else
            @foreach ($users as $user)
                <tr class="hover:bg-gray-100">

                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                        {{ $user->id }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                        {{ $user->name }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                        {{ $user->document_type }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                        {{ $user->document }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                        {{ $user->phone}}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5">
                        {{ $user->email }}
                    </td>
                    {{-- <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap lg:p-5">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div>
                        </div>
                    </td> --}}
                    <td class="p-4 space-x-2 whitespace-nowrap lg:p-5">
                        <button type="button" data-modal-toggle="user-modal"
                            class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 hover:text-gray-900 hover:scale-[1.02] transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <button type="button" data-modal-toggle="delete-user-modal"
                            class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-gradient-to-br from-red-400 to-red-600 rounded-lg shadow-md shadow-gray-300 hover:scale-[1.02] transition-transform">
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
    {{ $users->links() }}

    <div class="items-center p-4 my-4 mx-4 bg-white rounded-2xl shadow-xl shadow-gray-200 sm:flex sm:justify-between">
        <div class="flex items-center mb-4 sm:mb-0">
            <a href="#"
                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
            <a href="#"
                class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
            <span class="text-sm font-normal text-gray-500">Showing <span
                    class="font-semibold text-gray-900">1-20</span> of <span
                    class="font-semibold text-gray-900">2290</span></span>
        </div>
        <div class="flex items-center space-x-3">
            <a href="#"
                class="inline-flex flex-1 justify-center items-center py-2 px-3 text-sm font-medium text-center text-white bg-gradient-to-br from-dark-700 to-dark-900 rounded-lg shadow-md shadow-gray-300 hover:scale-[1.02] transition-transform">
                <svg class="mr-1 -ml-1 w-5 h-5"" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                Previous
            </a>
            <a href="#"
                class="inline-flex flex-1 justify-center items-center py-2 px-3 text-sm font-medium text-center text-white bg-gradient-to-br from-dark-700 to-dark-900 rounded-lg shadow-md shadow-gray-300 hover:scale-[1.02] transition-transform">
                Next
                <svg class="ml-1 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>

</div>

