<button {{ $attributes->merge(['type'=> 'submit', 'class'=>'py-3 px-5 w-full text-base font-medium text-center text-white bg-vulcan-600 from-pink-500 to-vulcan-500 hover:scale-[1.02] shadow-md shadow-gray-300 transition-transform rounded-lg sm:w-auto']) }}>
    {{ $slot }}
</button>