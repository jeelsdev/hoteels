<aside id="sidebar"
  class="flex hidden fixed top-0 left-0 z-20 flex-col flex-shrink-0 w-56 h-full duration-200 lg:flex transition-width"
  aria-label="Sidebar">
  <div class="flex relative flex-col flex-1 pt-0 min-h-0 bg-vulcan-950 shadow-md">
    <div class="flex overflow-y-auto flex-col flex-1 pt-8 pb-4">
      <div class="flex-1 bg-vulcan-950" id="sidebar-items">
        <ul class="pb-2 pt-1">
          <li>
            <x-partials.link-sidebar href="{{ route('dashboard.report') }}" :active="Route::is('dashboard.report')">
                <x-slot:svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                      </svg>
                </x-slot:svg>
                Dashboard
            </x-partials.link-sidebar>
          </li>
          <li>
            <x-partials.link-sidebar href="{{ route('reservation.index') }}" :active="Route::is('reservation.index')">
                <x-slot:svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                </x-slot:svg>
                Reservas
            </x-partials.link-sidebar>
          </li>
          <li>
            <x-partials.link-sidebar href="{{ route('xtras.index') }}" :active="Route::is('xtras.index')">
                <x-slot:svg>
                    <img src="{{ asset('images/svg/rectangle-group.svg') }}" alt="service" class="w-5">
                </x-slot:svg>
                Servicios
            </x-partials.link-sidebar>
          </li>
          <li>
            <x-partials.link-sidebar href="{{ route('room.index') }}" :active="Route::is('room.index')">
                <x-slot:svg >
                  <img src="{{ asset('images/svg/room.svg') }}" alt="room" class="w-6">
                </x-slot:svg>
                Habitaciones
            </x-partials.link-sidebar>
          </li>
          <li>
            <x-partials.link-sidebar href="{{ route('users.index') }}" :active="Route::is('users.index')">
                <x-slot:svg>
                    <img src="{{ asset('images/svg/users.svg') }}" alt="users" class="w-6">
                </x-slot:svg>
                Huespedes
            </x-partials.link-sidebar>
          </li>
          <li>
            <x-partials.link-sidebar>
                <x-slot:svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>

                </x-slot:svg>
                Historial
            </x-partials.link-sidebar>
          </li>
          
        </ul>
        <hr class="border-0 h-px bg-gradient-to-r from-gray-100 via-gray-300 to-gray-100">
        <div class="pt-2">
            <x-partials.link-sidebar href="{{ route('logout') }}" onclick="event.preventDefault()" method="POST">
                <x-slot:svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
    
                </x-slot:svg>
                Cerrar sesión
            </x-partials.link-sidebar>
          
        </div>
      </div>
    </div>
</aside>

<div class="hidden fixed inset-0 z-10 bg-gray-900 opacity-50" id="sidebarBackdrop"></div>