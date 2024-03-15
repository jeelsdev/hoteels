@props(['href'=>'#','notify'=>false, 'notifyName'=>'Pro', 'active'=>false, 'method'=>'GET'])



@if ($method == 'POST')
    <form method="POST" action="{{ $href }}" sidebar-toggle-collapse>
        @csrf
        <button type="submit" class="flex items-center py-2.5 px-4 text-base font-normal w-full text-dark-500 rounded-lg  group transition-all duration-200 {{ $active?'bg-white shadow-lg':'hover:bg-gray-200' }}">
          <div
            class="shadow-lg shadow-gray-300 text-dark-700 w-8 h-8  mr-1 rounded-lg text-center grid place-items-center {{ $active?'bg-fuchsia-500 text-white':'bg-white' }}">
            {{ $svg }}
          </div>
          <span class="ml-3 text-dark-500 text-sm font-light" sidebar-toggle-item>
            {{ $slot }}
          </span>

        </button>
    </form>
@else
  <a href="{{ $href }}"
              class="flex items-center py-2.5 px-4 text-base font-normal text-dark-500 rounded-lg  group transition-all duration-200 {{ $active?'bg-white shadow-lg':'hover:bg-gray-200' }}"
            sidebar-toggle-collapse>
            <div
                class="shadow-lg shadow-gray-300 text-dark-700 w-8 h-8  mr-1 rounded-lg text-center grid place-items-center {{ $active?'bg-fuchsia-500 text-white':'bg-white' }}">
               {{ $svg }}
              </div>
              <span class="ml-3 text-dark-500 text-sm font-light" sidebar-toggle-item>
                {{ $slot }}
              </span>
                @if($notify)
              <span
                class="bg-fuchsia-50 text-fuchsia-800 ml-auto text-sm font-medium inline-flex items-center justify-center px-2 rounded-full">{{ $notifyName }}</span>
                @endif
  </a>
@endif