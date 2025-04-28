@props([
    'internship',
    'searchedTag' => null,
    'showTransition' => false, // Controls whether to show the blur transition and overlay
    'containerClasses' => '', // Additional classes for the outer container
    'contentClasses' => '', // Additional classes for the main content area
    'tagsClasses' => '', // Additional classes for the tags container
    'linkEmployerName' => false, // Whether to wrap the employer name in an <a> tag
    'panelClasses' => 'flex gap-x-6' // Default panel classes, can be overridden
])

@php
    $tagsToShow = $searchedTag 
        ? $internship->randomTagsExcept($searchedTag->id, 3) 
        : $internship->randomTags(4);
@endphp

<div {{ $attributes->merge(['class' => 'relative group ' . $containerClasses]) }}>
    <x-panel {{ $attributes->merge(['class' => $panelClasses]) }}>
        <div>
            <x-employer-logo :employer="$internship->employer"/>
        </div>

        <div {{ $attributes->merge(['class' => 'flex-1 flex flex-col ' . ($showTransition ? 'group-hover:blur-sm transition-all duration-300 ' : '') . $contentClasses]) }}>
            <h3 class="mt-3 text-xl font-bold">
            @if($linkEmployerName)
            <a href="{{ route('myinternship.show', $internship) }}"> 
            {{ $internship->title }}</a>
            @else
                {{  $internship->title}}
            @endif
           </h3>   
            <p class="text-sm text-gray-400 mt-auto">{{ $internship->schedule }} - From {{ $internship->salary }}</p>
            <p class="text-xs text-gray-300 mt-2">Posted {{ $internship->created_at->diffForHumans() }}</p>
        </div>

        <div {{ $attributes->merge(['class' => 'tags ' . $tagsClasses]) }}>
            @if($searchedTag)
                <x-tag :tag="$searchedTag" size="small" highlight="true" />
            @endif
            @foreach ($tagsToShow as $tag)
                <x-tag :$tag size="small" />
            @endforeach
        </div>
    </x-panel>

    @if($showTransition)
        <div class="overlay absolute inset-0 flex flex-col justify-center items-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-400 border border-transparent rounded-xl group-hover:border-blue-800">
            <x-forms.anchor href="{{ route('internship.show', $internship) }}" target="_blank">Learn More</x-forms.anchor>
            <p class="text-sm text-gray-300 mt-2">Explore opportunities with us!</p>
        </div>
    @endif
</div>