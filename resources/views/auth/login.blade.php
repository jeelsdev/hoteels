<x-guest-layout>
    <div class="flex mt-32 flex-col w-full max-w-full px-3 mx-auto lg:mx-0 shrink-0 md:flex-0 lg:w-1/2">
        <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py4  rounded-2xl bg-clip-border">
            <a href="{{ route('login') }}" class="flex justify-center items-center mb-8 text-2xl font-semibold lg:mb-10">
                <img src="https://www.casonadejerusalen.com/favicons/favicon.ico" class="mr-4 h-10" alt="logo">
                <span class="self-center text-2xl font-bold whitespace-nowrap">La Casona de Jerusalén</span> 
            </a>
            <!-- Card -->
            <div class="mx-auto p-10 w-full max-w-lg bg-white rounded-2xl shadow-xl shadow-gray-300">
                <div class="space-y-8">
                    <h2 class="text-2xl font-bold text-gray-900 text-center">
                        Panel administrativo
                    </h2>
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <x-apps.label for="email">Correo electrónico</x-apps.label>
                            <x-apps.input type="email" name="email" id="email" value="{{ old('email') }}">
                            </x-apps.input>
                        </div>
                        <div>
                            <x-apps.label for="password">Contraseña</x-apps.label>
                            <x-apps.input type="password" name="password" id="password" autocomplete="current-password">
                            </x-apps.input>
                        </div>
                        {{-- <div class="flex items-start">
                            <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-5 h-5  rounded border-gray-300 focus:outline-none focus:ring-0 checked:bg-dark-900" required="false">
                            </div>
                            <div class="ml-3 text-sm">
                                <x-apps.label for="remember">Recordarme</x-apps.label>
                            </div>
                            @if (Route::has('password.request'))
                                <x-apps.link href="{{ route('password.request') }}" class="pl-5">Olvidaste tu contraseña?</x-apps.link>
                            @endif
                        </div> --}}
                        <x-apps.button>Iniciar sesión</x-apps.button>
                        {{-- <div class="text-sm font-medium text-gray-500">
                            No estas registrado?
                            <x-apps.link href="{{ route('register') }}">Crear cuenta</x-apps.link>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
      <div class="absolute top-0 right-0 flex-col justify-center hidden w-6/12 h-full max-w-full  my-auto text-center flex-0 lg:flex">
        <div class="relative flex flex-col justify-center h-full bg-cover overflow-hidden bg-[url('https://www.casonadejerusalen.com/img/imagen1.jpg')]">
        </div>
      </div>
</x-guest-layout>