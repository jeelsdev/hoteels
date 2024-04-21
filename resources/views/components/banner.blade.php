@props(['style' => session('flash.messageStyle', 'success'), 'message' => session('flash.message')])

@php
    $style = [
        'success' => 'bg-green-200 text-green-800',
        'error' => 'bg-red-200 text-red-800',
        'warning' => 'bg-yellow-200 text-yellow-800',
        'info' => 'bg-blue-200 text-blue-800',
    ][$style];
@endphp

@if($message)
    <div id="flash_message" class="relative z-50">
        <div class="w-full absolute lg:left-1/3 lg:right-1/4 lg:w-1/3 rounded-sm {{ $style }}">
            <div class="flex gap-3 justify-between">
                <p class="m-4 lg:my-1 lg:mx-5 flex items-center">
                    {{ $message }}
                </p>
                <div class="my-4 mr-4 lg:my-1 lg:mr-5">
                    <button id="close_flash_message" class="outline lg:outline-none text-white p-2 rounded-md bg-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('close_flash_message').addEventListener('click', function() {
                document.getElementById('flash_message').classList.add('hidden');
            });
        </script>
    </div>
@endif