@props([
    'internship',
    'showSaveButton' => true,
    'showApplyButton' => true,
    'colorScheme' => 'indigo', // Options: indigo, blue, purple, green
])

@php
    // Calculate days until deadline
    $daysLeft = null;
    $deadlineStatus = null;
    $urgentClass = 'text-gray-400';
    
    if ($internship->deadline_date) {
        $deadline = \Carbon\Carbon::parse($internship->deadline_date);
        $isFuture = $deadline->isFuture();
        
        if ($isFuture) {
            $daysLeft = round(now()->diffInDays($deadline, false));
            if ($daysLeft <= 3) {
                $deadlineStatus = 'expiring';
                $urgentClass = 'text-amber-500';
            }
        } else {
            $deadlineStatus = 'expired';
        }
    }
    // Define color classes based on the color scheme
    $colors = [
        'indigo' => [
            'primary' => 'text-indigo-700',
            'hover' => 'hover:text-indigo-700 hover:border-indigo-100',
            'decoration' => 'decoration-indigo-500',
            'icon' => 'text-indigo-500',
            'badge' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'deadline' => 'bg-amber-50 text-amber-700 border-amber-100',
            'tag' => 'bg-indigo-100 text-indigo-800',
            'button' => 'text-indigo-600 hover:text-indigo-800',
            'primary-button' => 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500'
        ],
        'blue' => [
            'primary' => 'text-blue-700',
            'hover' => 'hover:text-blue-700 hover:border-blue-100',
            'decoration' => 'decoration-blue-500',
            'icon' => 'text-blue-500',
            'badge' => 'bg-blue-100 text-blue-800 border-blue-200',
            'deadline' => 'bg-blue-50 text-blue-700 border-blue-100',
            'tag' => 'bg-blue-100 text-blue-800',
            'button' => 'text-blue-600 hover:text-blue-800',
            'primary-button' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'
        ],
        'purple' => [
            'primary' => 'text-purple-700',
            'hover' => 'hover:text-purple-700 hover:border-purple-100',
            'decoration' => 'decoration-purple-500',
            'icon' => 'text-purple-500',
            'badge' => 'bg-purple-100 text-purple-800 border-purple-200',
            'deadline' => 'bg-purple-50 text-purple-700 border-purple-100',
            'tag' => 'bg-purple-100 text-purple-800',
            'button' => 'text-purple-600 hover:text-purple-800',
            'primary-button' => 'bg-purple-600 hover:bg-purple-700 focus:ring-purple-500'
        ],
        'green' => [
            'primary' => 'text-green-700',
            'hover' => 'hover:text-green-700 hover:border-green-100',
            'decoration' => 'decoration-green-500',
            'icon' => 'text-green-500',
            'badge' => 'bg-green-100 text-green-800 border-green-200',
            'deadline' => 'bg-green-50 text-green-700 border-green-100',
            'tag' => 'bg-green-100 text-green-800',
            'button' => 'text-green-600 hover:text-green-800',
            'primary-button' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500'
        ],
    ];
    
    $color = $colors[$colorScheme] ?? $colors['indigo'];
@endphp

<div {{ $attributes->merge(['class' => "relative bg-white border border-gray-100 {$color['hover']} rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group"]) }}>
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-5">
            <!-- Company Logo -->
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-{{$colorScheme}}-50 rounded-lg border border-gray-100 overflow-hidden shadow-sm flex items-center justify-center">
                    @if($internship->employer && $internship->employer->employer_logo)
                        <img src="{{ Storage::url($internship->employer->employer_logo) }}" alt="{{ $internship->employer->employer_name }}" class="w-full h-full object-contain">
                    @elseif($internship->employer)
                        <span class="text-{{$colorScheme}}-700 font-semibold text-xl">{{ substr($internship->employer->employer_name, 0, 1) }}</span>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 {{ $color['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 leading-tight hover:{{ $color['primary'] }} transition-colors">
                            <a href="{{ route('internship.show', $internship) }}" class="hover:underline decoration-2 {{ $color['decoration'] }} underline-offset-2"> 
                                {{ $internship->title }}
                            </a>
                        </h3>
                        <div class="flex items-center mt-1.5 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $color['icon'] }} mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="text-sm">{{ $internship->employer->employer_name ?? 'Company Name' }}</span>
                        </div>
                    </div>

                    <div class="mt-2 sm:mt-0 flex space-x-2">
                        @if($internship->salary != 'Unpaid')
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                Paid
                            </span>
                        @endif
                        
                        @if($internship->schedule)
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $color['badge'] }}">
                                {{ $internship->schedule }}
                            </span>
                        @endif
                        
                        @if($daysLeft !== null && $daysLeft >= 0)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $deadlineStatus === 'expiring' ? 'bg-amber-50 text-amber-700 border-amber-100' : $color['deadline'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                            </span>
                        @elseif($deadlineStatus === 'expired')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Expired
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Brief Description -->
                @if($internship->description)
                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">
                        {{ $internship->description }}
                    </p>
                @endif
                
                <!-- Location and Details -->
                <div class="flex flex-wrap items-center mt-4 gap-x-4 gap-y-2 text-sm">
                    @if($internship->location && !$internship->is_remote)
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $internship->location }}
                        </div>
                    @endif
                    
                    @if($internship->schedule)
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $internship->schedule }}
                        </div>
                    @endif
                    
                    @if($internship->salary)
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $internship->salary }}
                        </div>
                    @endif
                </div>

                <!-- Tags -->
                @if($internship->tags && $internship->tags->count() > 0)
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($internship->tags->take(4) as $tag)
                        <a href="{{ route('tags.show', $tag) }}"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $loop->first ? $color['tag'] : 'bg-gray-100 text-gray-800' }}">
                                {{ $tag->name }}
                            </span></a>   
                        
                        @endforeach
                    </div>
                @endif
                
                <!-- Footer with posted time and apply button -->
                <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Posted {{ $internship->created_at->diffForHumans() }}
                    </div>
                    <div class="mt-3 sm:mt-0 flex">
                        @if($showApplyButton )
                            <a href="{{ route('internship.show', $internship) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white {{ $color['primary-button'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                                {{$internship->employer ? 'See more' : 'Apply Now'}}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>