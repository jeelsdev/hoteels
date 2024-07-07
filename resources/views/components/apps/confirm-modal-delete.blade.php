<div class="relative">
    <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 md:bottom-auto md:top-4 z-50 mb-4 mx-4 shadow-lg ">
        <div class="md:flex items-center">
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="text-sm text-gray-700 mt-1">
                    {{ $content }}
                </p>
            </div>
        </div>
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button id="confirm-delete-btn"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 text-red-950 rounded-lg font-semibold text-sm md:ml-2 md:order-2" wire:click="{{ $wireConfirm }}">
                Confirmar
            </button>
            <button id="confirm-cancel-btn"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4 md:mt-0 md:order-1" wire:click="$toggle('{{ $wireCancel }}')">
                Cancelar
            </button>
        </div>
    </div>
</div>
