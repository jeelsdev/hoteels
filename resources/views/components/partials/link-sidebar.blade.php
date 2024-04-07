@props(['href'=>'','notify'=>false, 'notifyName'=>'Pro', 'active'=>false, 'method'=>'GET'])



@if ($method == 'POST')
    <form method="POST" action="{{ $href }}" sidebar-toggle-collapse>
        @csrf
        <button type="submit" class="flex items-center py-2.5 px-4 text-base font-normal w-full text-white group transition-all duration-200 {{ $active?'bg-vulcan-999':'hover:bg-vulcan-999' }}">
          <div
            class="text-white w-8 h-8  mr-1 rounded-lg text-center grid place-items-center">
            {{ $svg }}
          </div>
          <span class="ml-3 text-sm font-light" sidebar-toggle-item>
            {{ $slot }}
          </span>

        </button>
    </form>
@else
  <a href="{{ $href }}"
              class="flex items-center py-2.5 px-4 text-base font-normal text-white group transition-all duration-200 {{ $active?'bg-vulcan-999':'hover:bg-vulcan-999' }}"
            sidebar-toggle-collapse>
            <div
                class="text-white w-8 h-8  mr-1 rounded-lg text-center grid place-items-center">
               {{ $svg }}
              </div>
              <span class="ml-3 text-sm font-light" sidebar-toggle-item>
                {{ $slot }}
              </span>
                @if($notify)
              <span
                class="bg-fuchsia-50 text-fuchsia-800 ml-auto text-sm font-medium inline-flex items-center justify-center px-2 rounded-full">{{ $notifyName }}</span>
                @endif
  </a>
@endif