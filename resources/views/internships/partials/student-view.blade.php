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
    <a href="{{ $internship->employer->website }}" class="text-blue-600 hover:underline flex items-center gap-1 mt-2" target="_blank">
        <x-icon.link class="h-4 w-4" /> Visit Company Website
    </a>
</div>

<div class="flex justify-between items-center border-t pt-6">
    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">← Back to Listings</a>
    
    @auth
        @can('create', [App\Models\Application::class, $internship])
            <a href="{{ route('applications.create', $internship) }}" class="btn btn-indigo">Apply Now</a>
        @elsecan('view', auth()->user()->applications()->where('internship_id', $internship->id)->first())
            <span class="btn btn-green"><x-icon.check class="h-5 w-5 mr-1" /> Already Applied</span>
        @elseif(auth()->user()->isEmployer() || auth()->user()->isAdmin())
            <span class="text-gray-500">You cannot apply as {{ auth()->user()->isAdmin() ? 'an admin' : 'an employer' }}</span>
        @elseif(!auth()->user()->is_active)
            <span class="text-red-500">Your account is suspended</span>
        @elseif($internship->deadline_date?->isPast())
            <button disabled class="btn btn-gray cursor-not-allowed">Application Closed</button>
        @else
            <span class="text-gray-500">You have reached the maximum number of applications</span>
        @endcan
    @else
        @if($internship->deadline_date?->isPast())
            <button disabled class="btn btn-gray cursor-not-allowed">Application Closed</button>
        @else
            <a href="{{ route('login') }}" class="btn btn-indigo">Login to Apply</a>
        @endif
    @endauth
</div>