@props(['href' => '#'])
<a href="{{ $href }}" {{ $attributes->merge(['class'=>'text-elf-green-600 hover:underline']) }}>
    {{ $slot }}
</a>