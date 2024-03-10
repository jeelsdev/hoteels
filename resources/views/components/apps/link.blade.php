@props(['href' => '#'])
<a href="{{ $href }}" {{ $attributes->merge(['class'=>'text-fuchsia-600 hover:underline']) }}>
    {{ $slot }}
</a>