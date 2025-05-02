@props([
    'internship',
    'colorScheme' => 'indigo', // Options: indigo, blue, purple, green
])

@php
    // Define color classes based on the color scheme
    $colors = [
        'indigo' => [
            'primary' => 'text-indigo-700',
            'hover' => 'hover:border-indigo-100',
            'decoration' => 'decoration-indigo-500',
            'gradient' => 'from-indigo-50',
            'accent' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'icon' => 'text-indigo-700',
            'tag' => 'bg-indigo-100 text-indigo-800',
            'button' => 'text-indigo-600 hover:text-indigo-800',
        ],
        'blue' => [
            'primary' => 'text-blue-700',
            'hover' => 'hover:border-blue-100',
            'decoration' => 'decoration-blue-500',
            'gradient' => 'from-blue-50',
            'accent' => 'bg-blue-100 text-blue-800 border-blue-200',
            'icon' => 'text-blue-700',
            'tag' => 'bg-blue-100 text-blue-800',
            'button' => 'text-blue-600 hover:text-blue-800',
        ],
        'purple' => [
            'primary' => 'text-purple-700',
            'hover' => 'hover:border-purple-100',
            'decoration' => 'decoration-purple-500',
            'gradient' => 'from-purple-50',
            'accent' => 'bg-purple-100 text-purple-800 border-purple-200',
            'icon' => 'text-purple-700',
            'tag' => 'bg-purple-100 text-purple-800',
            'button' => 'text-purple-600 hover:text-purple-800',
        ],
        'green' => [
            'primary' => 'text-green-700',
            'hover' => 'hover:border-green-100',
            'decoration' => 'decoration-green-500',
            'gradient' => 'from-green-50',
            'accent' => 'bg-green-100 text-green-800 border-green-200',
            'icon' => 'text-green-700',
            'tag' => 'bg-green-100 text-green-800',
            'button' => 'text-green-600 hover:text-green-800',
        ],
    ];
    
    $color = $colors[$colorScheme] ?? $colors['indigo'];
    
    // Get company initials
    $initials = '';
    if ($internship->employer) {
        $words = explode(' ', $internship->employer->employer_name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        $initials = substr($initials, 0, 2);
    }
    
    // Determine status badge
    $status = null;
    $statusClass = '';
    
    if ($internship->featured) {
        $status = 'Featured';
        $statusClass = 'bg-amber-100 text-amber-800';
    } elseif ($internship->salary != 'Unpaid') {
        $status = 'Paid';
        $statusClass = 'bg-green-100 text-green-800';
    } elseif ($internship->created_at->gt(now()->subDays(6))) {
        $status = 'New';
        $statusClass = $color['accent'];
    }
@endphp
<div {{ $attributes->merge(['class' => "bg-white border border-gray-100 {$color['hover']} rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col h-full"]) }}>
    <div class="border-b border-gray-100 bg-gradient-to-r {{ $color['gradient'] }} to-white px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-md bg-{{$colorScheme}}-100 flex items-center justify-center mr-3 border border-{{$colorScheme}}-200">
                    @if($internship->employer && $internship->employer->employer_logo)
                        <img src="{{ Storage::url($internship->employer->employer_logo) }}" alt="{{ $internship->employer->employer_name }}" class="w-full h-full object-contain">
                    @else
                        <span class="{{ $color['icon'] }} font-semibold text-sm">{{ $initials }}</span>
                    @endif
                </div>
                <h4 class="font-medium text-gray-900 truncate">{{ $internship->employer->employer_name ?? 'Company' }}</h4>
            </div>
            @if($status)
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium {{ $statusClass }}">
                    {{ $status }}
                </span>
            @endif
        </div>
    </div>
    
    <div class="p-4 flex-1 flex flex-col">
        <!-- Main content -->
        <div class="flex-1">
            <h3 class="font-bold text-gray-900 leading-snug mb-2 hover:{{ $color['primary'] }} transition-colors">
                <a href="{{ route('internship.show', $internship) }}" class="hover:underline decoration-2 {{ $color['decoration'] }} underline-offset-2">
                    {{ $internship->title }}
                </a>
            </h3>
            
            @if($internship->tags && $internship->tags->count() > 0)
                <div class="flex flex-wrap gap-1 mb-3">
                    @foreach($internship->tags->take(3) as $tag)
                    <a href="{{ route('tags.show', $tag) }}"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $loop->first ? $color['tag'] : 'bg-gray-100 text-gray-800' }}">
                            {{ $tag->name }}
                        </span></a>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Location and schedule info moved to directly above footer -->
        <div class="flex flex-wrap text-xs text-gray-600 mb-3 gap-x-3 gap-y-1">
            @if($internship->location)
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    {{ $internship->location }}
                </div>
            @endif
            
            @if($internship->schedule)
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $internship->schedule }}
                </div>
            @endif
        </div>
        
        <!-- Footer - always at the bottom -->
        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
            @if($internship->deadline && \Carbon\Carbon::parse($internship->deadline)->isFuture())
                @php
                    $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($internship->deadline_date), false);
                    $urgentClass = $daysLeft <= 3 ? 'text-amber-500' : 'text-gray-400';
                @endphp
                <div class="flex items-center text-xs text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 {{ $urgentClass }} mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                </div>
            @else
                <div class="flex items-center text-xs text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Posted {{ $internship->created_at->diffForHumans() }}
                </div>
            @endif
            
            <a href="{{ route('internship.show', $internship) }}" class="inline-flex items-center text-xs font-medium {{ $color['button'] }}">
                View Details
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-0.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>