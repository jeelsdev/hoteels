@props(['id'=>'#'])

<select id="{{ $id }}"  {!! $attributes->merge(['class'=>'border-gray-300 focus:border-vulcan-500 focus:ring-vulcan-500 rounded-sm shadow-sm']) !!}>
    {{ $slot }}
</select>