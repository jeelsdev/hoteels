<div class="border border-gray-500 rounded-sm p-4 mt-5 bg-gray-300">
    <h3 class="font-semibold">Huéspedes</h3>
    <div class="mt-5">
        <div class="w-full overflow-x-auto">
            <div class="relative right-0">
                <ul class="flex justify-start gap-3 list-none rounded-lg">
                    @foreach ($users as $key => $user)
                        <li class="z-10 px-4 border border-gray-100 rounded-t-md {{ $key == $tab ? 'bg-white border-b-0' : 'bg-gray-300 hover:bg-gray-200' }}"
                            wire:click="setTab('{{ $key }}')">
                            <x-admin.user-button :value="$loop->iteration" />
                        </li>
                    @endforeach
                    <li class="z-10 px-4 border border-gray-100 rounded-t-md hover:bg-gray-100 bg-gray-300"
                        wire:click="setUser()">
                        <x-admin.user-add />
                    </li>
                </ul>
            </div>
            <div class="border border-gray-400 py-10 px-8 bg-white">
                @foreach ($users as $key => $user)
                    <div class="{{ $key == $tab ? '' : 'hidden' }}">
                        <x-admin.user-form :key="$key" />
                    </div>
                    @if (!$loop->first)
                        <div class="flex justify-end mt-5 {{ $key == $tab ? '' : 'hidden' }}">
                            <x-admin.user-remove :key="$key" />
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
