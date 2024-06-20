@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-vulcan-500 focus:ring-vulcan-500 rounded-sd shadow-sm remove-arrow']) !!}>
