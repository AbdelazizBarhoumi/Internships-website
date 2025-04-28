@props(['label', 'value', 'class' => 'text-gray-800'])
<div class="bg-white p-3 rounded shadow-sm border">
    <p class="text-sm text-gray-500">{{ $label }}</p>
    <p class="text-2xl font-bold {{ $class }}">{{ $value }}</p>
</div>