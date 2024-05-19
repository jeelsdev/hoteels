<nav class="z-30 bg-gray-50 lg:ml-56 shadow-md">
    <div class="py-1 px-3 lg:px-5">
      <div class="flex justify-between items-center">
        <div class="flex justify-start items-center">
          <button id="toggleSidebarMobileSearch" type="button" class="p-2 text-gray-500 rounded-2xl lg:hidden hover:text-gray-900 hover:bg-gray-100">
            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
          <div class="hidden lg:flex items-center">
            <div class="mr-3 bg-elf-green-600 p-2 rounded-md">
              <img src="{{ asset('images/svg/'.$icon) }}" alt="chart-pie" width="25px" class="text-white">
            </div>
            <div>
              <h2 class="font-body font-bold text-md">
                {{ $title }}
              </h2>
              <ul class="flex gap-5">
                @foreach ($items as $item)
                <li>
                    <x-nav-link href="{{ route($item['route']) }}" :active="Route::is($item['route'])">{{ $item['name'] }}</x-nav-link>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="flex lg:hidden items-center">
          <div>
            <ul class="flex gap-2">
                @foreach ($items as $item)
                <li>
                    <x-nav-link href="{{ route($item['route']) }}" :active="Route::is($item['route'])">{{ $item['name'] }}</x-nav-link>
                </li>
                @endforeach
            </ul>
          </div>
        </div>
        <div class="flex items-center">
            <a href="#">Dash</a>
        </div>
      </div>
    </div>
</nav>