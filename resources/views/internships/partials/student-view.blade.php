<div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
    <div class="flex items-center gap-4">
        @if($internship->employer->employer_logo)
            <img src="{{ Storage::url($internship->employer->employer_logo) }}" alt="{{ $internship->employer->employer_name }} logo" class="h-16 w-16 object-contain rounded-lg border bg-white p-2">
        @else
            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
        @endif
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $internship->title }}</h1>
            <p class="text-gray-600 flex items-center gap-1">
                {{ $internship->employer->employer_name }}
                @if($internship->employer->industry)
                    <span class="text-gray-400 px-1">•</span>
                    <span class="text-sm bg-gray-100 text-gray-700 px-2 py-0.5 rounded">{{ $internship->employer->industry }}</span>
                @endif
            </p>
        </div>
    </div>
    <div class="flex flex-col sm:items-end gap-2">
        <x-internship.featured-badge :internship="$internship" />
        <x-internship.deadline-badge :internship="$internship" />
    </div>
</div>

<!-- Enhanced info cards with additional employer data -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-gray-50 p-3 rounded border">
        <p class="text-xs text-gray-500 uppercase font-semibold">Salary</p>
        <p class="font-medium">{{ $internship->salary }}</p>
    </div>
    <div class="bg-gray-50 p-3 rounded border">
        <p class="text-xs text-gray-500 uppercase font-semibold">Location</p>
        <p class="font-medium">{{ $internship->location ?: $internship->employer->location ?: 'Not specified' }}</p>
    </div>
    <div class="bg-gray-50 p-3 rounded border">
        <p class="text-xs text-gray-500 uppercase font-semibold">Schedule</p>
        <p class="font-medium">{{ $internship->schedule }}</p>
    </div>
    <div class="bg-gray-50 p-3 rounded border">
        <p class="text-xs text-gray-500 uppercase font-semibold">Duration</p>
        <p class="font-medium">{{ $internship->duration ?? 'Not specified' }}</p>
    </div>
</div>

<x-internship.deadline :internship="$internship" />
<x-internship.description :internship="$internship" />
<x-internship.tags :tags="$internship->tags" />

<!-- Enhanced employer section -->
<div class="mb-8 mt-8 bg-white border rounded-lg overflow-hidden">
    <div class="bg-gray-50 px-4 py-3 border-b">
        <h2 class="text-lg font-semibold">About {{ $internship->employer->employer_name }}</h2>
    </div>
    
    <div class="p-4">
        <div class="prose max-w-none text-gray-700">
            {{ $internship->employer->description ?? 'No description available.' }}
        </div>
        
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($internship->employer->website)
                <div>
                    <p class="text-sm text-gray-500 mb-1">Website</p>
                    <a href="{{ $internship->employer->website }}" class="text-blue-600 hover:underline flex items-center gap-1" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        {{ parse_url($internship->employer->website, PHP_URL_HOST) ?: $internship->employer->website }}
                    </a>
                </div>
            @endif
            
            @if($internship->employer->phone)
                <div>
                    <p class="text-sm text-gray-500 mb-1">Contact Phone</p>
                    <p class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $internship->employer->phone }}
                    </p>
                </div>
            @endif
            
            @if($internship->employer->employer_email)
                <div>
                    <p class="text-sm text-gray-500 mb-1">Contact Email</p>
                    <a href="mailto:{{ $internship->employer->employer_email }}" class="text-blue-600 hover:underline flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $internship->employer->employer_email }}
                    </a>
                </div>
            @endif
            
            @if($internship->employer->location)
                <div>
                    <p class="text-sm text-gray-500 mb-1">Headquarter Location</p>
                    <p class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $internship->employer->location }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="flex justify-between items-center border-t pt-6">
    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Listings
    </a>
    
    @auth
        @can('create', [App\Models\Application::class, $internship])
            <a href="{{ route('applications.create', $internship) }}" class="btn btn-indigo flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Apply Now
            </a>
        @elsecan('view', auth()->user()->applications()->where('internship_id', $internship->id)->first())
            <span class="btn btn-green flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Already Applied
            </span>
        @elseif(auth()->user()->isEmployer() || auth()->user()->isAdmin())
            <span class="text-gray-500">You cannot apply as {{ auth()->user()->isAdmin() ? 'an admin' : 'an employer' }}</span>
        @elseif(!auth()->user()->is_active)
            <span class="text-red-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Your account is suspended
            </span>
        @elseif($internship->deadline_date?->isPast())
            <button disabled class="btn btn-gray cursor-not-allowed flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Application Closed
            </button>
        @else
            <span class="text-gray-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                You have reached the maximum number of applications
            </span>
        @endcan
    @else
        @if($internship->deadline_date?->isPast())
            <button disabled class="btn btn-gray cursor-not-allowed flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Application Closed
            </button>
        @else
            <a href="{{ route('login') }}" class="btn btn-indigo flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Login to Apply
            </a>
        @endif
    @endauth
</div>