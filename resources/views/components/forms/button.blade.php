<button {{ $attributes->merge(['type' => 'submit', 'class' => 'block px-4 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-r-md text-white font-medium focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}>
    {{ $slot }}
</button>   