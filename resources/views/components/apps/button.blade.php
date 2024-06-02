<button {{ $attributes->merge(['type'=> 'submit', 'class'=>'py-2 px-5 w-full text-base font-medium text-center text-white bg-elf-green-600 from-pink-500 to-elf-green-500 hover:scale-[1.02] shadow-md shadow-gray-300 transition-transform rounded-lg sm:w-auto flex justify-center items-center hover:bg-elf-green-500']) }}>
    {{ $slot }}
</button>