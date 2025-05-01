@props(['size' => 'base', 'tag', 'highlight' => false])
@php
$classes = ($highlight 
    ? 'bg-indigo-600 text-white hover:bg-indigo-700' 
    : 'bg-gray-100 text-gray-800 hover:bg-gray-200') . ' rounded-md font-medium transition-colors duration-200';
    
    if ($size == 'base') {
        $classes .= ' text-sm px-4 py-1';
    } elseif ($size == 'small') {
        $classes .= ' text-xs px-2 py-0.5';
    }
    
    // Use tag ID in URL instead of name
@endphp
<a href="{{ route('tags.show', $tag->id) }}" class="{{ $classes }}">{{ $tag->name }}</a>