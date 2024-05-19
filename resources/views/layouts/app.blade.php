<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>

<body class="font-sans antialiased">
    <div id="loading-overlay" class="absolute z-50 w-full h-screen bg-[#ffffffcc] scroll-smooth hidden">
        <x-apps.global-loading />
    </div>
    <x-banner />

    <div class="min-h-screen bg-zinc-100">
        <livewire:layouts.navigation />
        @include('layouts.components.sidebar')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div id="main-content" class="h-full bg-zinc-100 relative overflow-y-auto lg:ml-60 mt-5">
                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('scripts')
    <script>
        const loadingOverlay = document.getElementById('loading-overlay');
    </script>
</body>

</html>
