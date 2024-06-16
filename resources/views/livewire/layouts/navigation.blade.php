<nav class="z-30 bg-gray-50 lg:ml-56 shadow-md">
    <div class="py-1 px-3 lg:px-5">
        <div class="flex justify-between items-center">
            <div class="flex justify-start items-center">
                <button id="toggleSidebarMobileSearch" type="button"
                    class="p-2 text-gray-500 rounded-2xl lg:hidden hover:text-gray-900 hover:bg-gray-100">
                    <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="hidden lg:flex items-center">
                    <div class="mr-3 bg-elf-green-600 p-2 rounded-md">
                        <img src="{{ asset('images/svg/' . $icon) }}" alt="chart-pie" width="25px" class="text-white">
                    </div>
                    <div>
                        <h2 class="font-body font-bold text-md">
                            {{ $title }}
                        </h2>
                        <ul class="flex gap-5">
                            @foreach ($items as $item)
                                <li>
                                    <x-nav-link href="{{ route($item['route']) }}"
                                        :active="Route::is($item['route'])">{{ $item['name'] }}</x-nav-link>
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
                                <x-nav-link href="{{ route($item['route']) }}"
                                    :active="Route::is($item['route'])">{{ $item['name'] }}</x-nav-link>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="flex items-center">
                <img alt="tania andrew"
                    src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1480&amp;q=80"
                    class="relative inline-block h-10 w-10 cursor-pointer rounded-full object-cover object-center" wire:click="openProfileMenu()"/>
                <ul role="menu" class="absolute top-14 right-3 lg:top-16 lg:right-4 z-10 flex min-w-[100px] md:min-w-[180px] flex-col gap-2 overflow-auto rounded-md border border-gray-50 bg-white p-3 font-sans text-sm font-normal text-gray-800 shadow-lg shadow-gray-500/10 focus:outline-none {{ $open?'':'hidden' }}">
                    {{-- <button tabIndex="-1" role="menuitem"
                        class="flex w-full cursor-pointer select-none items-center gap-2 rounded-md px-3 pt-[9px] pb-2 text-start leading-tight outline-none transition-all hover:bg-vulcan-100 hover:bg-opacity-80 hover:text-gray-900 focus:bg-gray-50 focus:bg-opacity-80 focus:text-gray-900 active:bg-gray-50 active:bg-opacity-80 active:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" aria-hidden="true" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                        <p class="block font-sans text-sm font-normal leading-normal text-inherit antialiased">
                            Mi perfil
                        </p>
                    </button> --}}
                    <form action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button type="submit" class="flex w-full cursor-pointer select-none items-center gap-2 rounded-md px-3 pt-[9px] pb-2 text-start leading-tight outline-none transition-all hover:bg-vulcan-100 hover:bg-opacity-80 hover:text-gray-900 focus:bg-gray-50 focus:bg-opacity-80 focus:text-gray-900 active:bg-gray-50 active:bg-opacity-80 active:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" aria-hidden="true" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.636 5.636a9 9 0 1012.728 0M12 3v9"></path>
                        </svg>
                        <p class="block font-sans text-sm font-normal leading-normal text-inherit antialiased">
                            Cerrar sesión
                        </p>
                      </button>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>
