<div class="mb-5">
    <div class="flex justify-between items-center mx-4">
        <div></div>
        <x-apps.link-button href="{{ route('user.create') }}">
            <x-slot name="svg">
                <svg class="mr-2 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </x-slot>
            Agregar huésped
        </x-apps.link-button>
    </div>
    <div class="block justify-between items-center mx-4 mt-4 bg-white rounded-sm p-5 sm:flex">
        <div class="mb-1 w-full">
            <div class="block items-center sm:flex md:divide-x md:divide-gray-100">
                <div class="relative mt-1 sm:w-64 xl:w-96">
                    <x-apps.input wire:model.live="search" placeholder="Buscar por nombre o n° de documento">
                    </x-apps.input>
                </div>
                {{-- <div class="flex items-center w-full sm:justify-end gap-5">
                    <div>
                        <x-apps.label for="roomType" class="text-gray-500">Tipo de habitación</x-apps.label>
                        <x-apps.select wire:model.live="roomType" id="roomType" name="roomType">
                            <option></option>
                            @foreach ($roomTypes as $key => $type)
                                <option value="{{ $key }}">{{ $type }}</option>
                            @endforeach
                        </x-apps.select>
                    </div>
                    <div>
                        <x-apps.label for="floor" class="text-gray-500">
                            Piso
                        </x-apps.label>
                        <x-apps.select wire:model.live="floor" id="floor">
                            <option></option>
                            <option value="asc">Ascendente</option>
                            <option value="desc">Descendente</option>
                        </x-apps.select>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <x-apps.table>
        <x-slot name="head">
            <tr>
                <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase lg:p-2">
                    id
                </th>
                <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase lg:p-2">
                    Nombre
                </th>
                <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase lg:p-2">
                    Tipo de documento
                </th>
                <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase lg:p-2">
                    Documento
                </th>
                <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase lg:p-2">
                    Teléfono
                </th>
                <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase lg:p-2">
                    Email
                </th>
                <th scope="col" class="p-2 lg:p-5 w-5">
                </th>
            </tr>
        </x-slot>
        @if ($users->isEmpty())
            <tr>
                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-5" colspan="6">
                    No se encontraron huéspedes
                </td>
            </tr>
        @else
            @foreach ($users as $user)
                <tr class="hover:bg-gray-100">

                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-2">
                        {{ $user->id }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-2">
                        {{ $user->name }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-2">
                        {{ $user->document_type }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-2">
                        {{ $user->document }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-2">
                        {{ $user->phone }}
                    </td>
                    <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap lg:p-2">
                        {{ $user->email }}
                    </td>
                    <td class="px-4 py-1 lg:px-5 lg:py-2 space-x-2 whitespace-nowrap flex items-center mt-1">
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="block">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="{{ route('user.history', ['id'=>$user->id]) }}" class="block w-6">
                            <img src="{{ asset('images/svg/eye.svg') }}" alt="eye" width="30">
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif
    </x-apps.table>
    <div class="mx-4 mt-5">
        {{ $users->links() }}
    </div>
</div>
