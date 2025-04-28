@props(['internship'])
<div class="relative group h-64">
        <x-panel class="flex flex-col text-center h-full">
            <div class="self-start text-sm">{{ $internship->employer->name }}</div>
            <div class="py-8 flex-grow flex flex-col justify-center group-hover:blur-sm transition-all duration-300"> <!-- Modified: Kept centering styles; added 'group-hover:blur-sm' to blur content on hover; added 'transition-all' for smooth blur -->
            <h3 class=" text-xl font-bold">
{{ $internship->title }}
                </h3>
                <p class="text-sm mt-4">{{ $internship->schedule }} - From {{ $internship->salary }}</p>
                <p class="text-xs text-gray-300 mt-2">Posted {{ $internship->created_at->diffForHumans() }}</p>
            </div>
            <div class="flex justify-between items-center mt-auto">
            <div class="tags z-10 flex flex-wrap gap-1"> <!-- Modified: Removed 'group-hover:blur-sm' to prevent tags from blurring; added 'tags' class and 'z-10' to position tags above the overlay -->
            @foreach ($internship->randomTags() as $tag)
                        <x-tag :$tag size="small" />
                    @endforeach
                </div>
                <x-employer-logo :employer="$internship->employer" :width="42" />
            </div>
        </x-panel>
        <div class="overlay absolute inset-0 flex flex-col justify-center items-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-400 border border-transparent rounded-xl group-hover:border-blue-800"> <!-- Added: New overlay div; 'absolute inset-0' to cover the entire card; 'flex' to center content; 'opacity-0' to start invisible; 'group-hover:opacity-100' to fade in on hover; 'transition-opacity' for smooth fade -->
        <!-- Modified: Added 'h-full' to ensure the back side stretches to the full height; retained original styling -->
            <x-forms.anchor href="{{ route('internship.show', $internship) }}" target="_blank">Learn More</x-forms.anchor>
                <p class="text-sm text-gray-300 mt-2">Explore opportunities with us!</p>
            <!-- No change: Original back side description -->
        </div>

</div>