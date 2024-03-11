@props(['href'=>'#','notify'=>false, 'notifyName'=>'Pro', 'active'=>false])

<a href="{{ $href }}"
              class="flex items-center py-2.5 px-4 text-base font-normal text-dark-500 rounded-lg hover:bg-gray-200 group transition-all duration-200 {{ $active?'bg-white shadow-lg':'' }}"
            sidebar-toggle-collapse>
            <div
                class="bg-white shadow-lg shadow-gray-300 text-dark-700 w-8 h-8  mr-1 rounded-lg text-center grid place-items-center {{ $active?'bg-fuchsia-500':'' }}">
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