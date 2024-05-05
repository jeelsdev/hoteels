@props(['rows'=>'6', 'placeholder'=>''])

<textarea  placeholder="{{ $placeholder }}" {{ $attributes->merge(['class'=>'block p-4 w-full text-gray-900 border border-gray-300 sm:text-sm rounded-sm focus:ring-2 focus:ring-indigo-50 focus:border-indigo-300']) }}>{{ $slot }}</textarea>