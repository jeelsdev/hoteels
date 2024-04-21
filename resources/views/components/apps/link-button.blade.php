@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-gradient-to-br bg-elf-green-600 to-voilet-500 sm:ml-auto shadow-md shadow-gray-300 hover:bg-elf-green-500']) }}>
    {{ $svg?? ''}}
    {{ $slot }}
</a>