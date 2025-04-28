@props([
    'name',
    'label' => '',
    'checked' => false,
])

<div class="flex items-start mb-2">
    <div class="flex items-center h-5">
        <input 
            type="checkbox"
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $checked ? 'checked' : '' }}
            {{ $attributes->merge(['class' => 'h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500']) }}
        >
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $name }}" class="font-medium text-gray-700">{{ $label }}</label>
    </div>
</div>

@error($name)
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror