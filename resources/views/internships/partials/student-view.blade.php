<div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $internship->title }}</h1>
        <p class="text-gray-600">{{ $internship->employer->company_name }}</p>
    </div>
    <div class="flex flex-col sm:items-end gap-2">
        <x-internship.featured-badge :internship="$internship" />
        <x-internship.deadline-badge :internship="$internship" />
    </div>
</div>

<x-internship.info-cards :internship="$internship" />
<x-internship.deadline :internship="$internship" />
<x-internship.description :internship="$internship" />
<x-internship.tags :tags="$internship->tags" />

<div class="mb-6">
    <h2 class="text-lg font-semibold mb-2">About {{ $internship->employer->company_name }}</h2>
    <p class="text-gray-700">{{ $internship->employer->description ?? 'No description available.' }}</p>
    <a href="{{ $internship->url }}" class="text-blue-600 hover:underline flex items-center gap-1 mt-2" target="_blank">
        <x-icon.link class="h-4 w-4" /> Visit Company Website
    </a>
</div>

<div class="flex justify-between items-center border-t pt-6">
    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">← Back to Listings</a>
    @if($internship->deadline?->isPast())
        <button disabled class="btn btn-gray cursor-not-allowed">Application Closed</button>
    @else
        @auth
            @if(auth()->user()->hasAppliedTo($internship))
                <span class="btn btn-green"><x-icon.check class="h-5 w-5 mr-1" /> Already Applied</span>
            @else
                <a href="{{ route('applications.create', $internship) }}" class="btn btn-indigo">Apply Now</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-indigo">Login to Apply</a>
        @endauth
    @endif
</div>