<form wire:submit="save" >
    <x-dialog-modal maxWidth="2xl" wire:model="open">
        <x-slot name="title">
            {{ __('Create Reservation') }}
        </x-slot>
        <x-slot name="content">
            <div class="mt-4 text-sm text-gray-600">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label for="start_date" value="{{ __('Start Date') }}" />
                        <x-input id="start_date" type="date" class="mt-1 block w-full" wire:model="start_date" value="{{ $start_date }}"/>
                        <x-input-error for="start_date" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="end_date" value="{{ __('End Date') }}" />
                        <x-input id="end_date" type="date" class="mt-1 block w-full" wire:model="end_date" />
                        <x-input-error for="end_date" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <x-label for="user_id" value="{{ __('User') }}" />
                        <select id="user_id" class="chosen-select mt-1 block w-full" wire:model="user_id">
                            <option value="">Seleccionar usuario</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="user_id" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-label for="origin" value="{{ __('Origin') }}" />
                        <x-input id="origin" class="mt-1 block w-full" wire:model="origin" />
                        <x-input-error for="origin" class="mt-2" />
                    </div>
                    
                    <div>
                        <x-label for="room_id" value="{{ __('Room') }}" />
                        <select id="room_id" class="mt-1 block w-full" wire:model="room_id">
                            <option value="">Seleccionar habitación</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $room->id==$room_id?'selected':'' }}>{{ $room->code }}-{{ $room->roomType->description }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="room_id" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="status_id" value="{{ __('Status') }}" />
                        <select id="status_id" class="mt-1 block w-full" wire:model="status_id">
                            <option value="">Seleccionar estado</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="status_id" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="unit_price" value="{{ __('Unit price') }}" />
                        @php
                            foreach ($rooms as $room) {
                                if ($room->id == $room_id) {
                                    $unit_price = $room->roomType->price;
                                }
                            }
                        @endphp
                        <x-input id="unit_price" type="number" value="{{ $unit_price??'' }}" class="mt-1 block w-full" wire:model="unit_price" disabled/>
                    </div>
                    <div>
                        <x-label for="total" value="{{ __('Total') }}" />
                        <x-input id="total" type="number" class="mt-1 block w-full" wire:model="total" />
                        <x-input-error for="total" class="mt-2" />
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-button class="ml-2" wire:loading.attr="disabled" type="submit">
                {{ __('Create') }}
            </x-button>
        </x-slot>

    </x-dialog-modal>
</form>
