<x-layout :showHero="false">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Search Header with Visual Enhancement -->
        <div class="bg-gradient-to-r from-white to-indigo-50 rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 sm:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        @if ($search == '')
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Discover Your Perfect Internship</h1>
                            <p class="text-gray-600 max-w-xl">Browse through opportunities that match your skills and interests</p>
                        @else
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Results for "{{ $search }}"</h1>
                            <p class="text-gray-600">Found {{ $internships->total() }} {{ Str::plural('internship', $internships->total()) }} matching your search</p>
                        @endif
                    </div>
                    
                    <div class="flex-grow lg:max-w-xl w-full">
                        <form action="{{ url('/search') }}" method="GET" class="flex flex-row items-center relative">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input 
                                    type="text"
                                    name="search" 
                                    value="{{ $search }}" 
                                    placeholder="Job title, company, or keyword..." 
                                    class="w-full bg-white border border-gray-300 rounded-l-lg pl-11 pr-4 py-3.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" 
                                />
                            </div>
                            <button type="submit" class="shrink-0 bg-indigo-600 hover:bg-indigo-700 text-white rounded-r-lg px-5 py-3.5 font-medium transition-colors border border-indigo-600 shadow-sm">
                                Search
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Advanced Search Options Toggle -->
                <div x-data="{ open: false }" class="mt-5">
                    <button @click="open = !open" type="button" class="flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span x-text="open ? 'Hide filters' : 'Show advanced filters'">Show advanced filters</span>
                    </button>

                    <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-gray-200">
                        <form action="{{ url('/search') }}" method="GET">
                            <input type="hidden" name="search" value="{{ $search }}">
                            @if(request('filter'))
                                <input type="hidden" name="filter" value="{{ request('filter') }}">
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <select id="location" name="location" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">Any location</option>
                                        <option value="remote" {{ request('location') == 'remote' ? 'selected' : '' }}>Remote</option>
                                        <option value="hybrid" {{ request('location') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        <option value="onsite" {{ request('location') == 'onsite' ? 'selected' : '' }}>On-site</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                                    <select id="duration" name="duration" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">Any duration</option>
                                        <option value="summer" {{ request('duration') == 'summer' ? 'selected' : '' }}>Summer internship</option>
                                        <option value="3-month" {{ request('duration') == '3-month' ? 'selected' : '' }}>3 months</option>
                                        <option value="6-month" {{ request('duration') == '6-month' ? 'selected' : '' }}>6 months</option>
                                        <option value="12-month" {{ request('duration') == '12-month' ? 'selected' : '' }}>12 months</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="paid" class="block text-sm font-medium text-gray-700 mb-1">Compensation</label>
                                    <select id="paid" name="paid" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">Any compensation</option>
                                        <option value="paid" {{ request('paid') == 'paid' ? 'selected' : '' }}>Paid only</option>
                                        <option value="unpaid" {{ request('paid') == 'unpaid' ? 'selected' : '' }}>Unpaid accepted</option>
                                        <option value="stipend" {{ request('paid') == 'stipend' ? 'selected' : '' }}>With stipend</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>

        <!-- Results Section -->
        <div class="space-y-6">
            @if($internships->count() > 0)
                <!-- Results Controls -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-4">
                    <div class="text-sm text-gray-500 mb-3 sm:mb-0 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Showing <span class="font-medium text-gray-900">{{ $internships->firstItem() ?? 0 }}-{{ $internships->lastItem() ?? 0 }}</span> of <span class="font-medium text-gray-900">{{ $internships->total() }}</span> results
                    </div>
                    
                    <div class="flex items-center">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mr-2">Sort by:</label>
                        <form id="sortForm" action="{{ url('/search') }}" method="GET" class="inline">
                            <input type="hidden" name="search" value="{{ $search }}">
                            @if(request('filter'))
                                <input type="hidden" name="filter" value="{{ request('filter') }}">
                            @endif
                            @if(request('location'))
                                <input type="hidden" name="location" value="{{ request('location') }}">
                            @endif
                            @if(request('duration'))
                                <input type="hidden" name="duration" value="{{ request('duration') }}">
                            @endif
                            @if(request('paid'))
                                <input type="hidden" name="paid" value="{{ request('paid') }}">
                            @endif
                            
                            <select id="sort" name="sort" onchange="this.form.submit()" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white shadow-sm">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest first</option>
                                <option value="relevant" {{ request('sort') == 'relevant' ? 'selected' : '' }}>Most relevant</option>
                                <option value="expiring" {{ request('sort') == 'expiring' ? 'selected' : '' }}>Expiring soon</option>
                                <option value="company" {{ request('sort') == 'company' ? 'selected' : '' }}>Company name</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Results Cards -->
                @foreach ($internships as $internship)
            <x-internship-card-wide-tr :internship="$internship" :searchedTag="$searchedTag ?? null" />
                 @endforeach

                <!-- Pagination -->
                @if($internships->hasPages())
                <div class="mt-10 pt-5 border-t border-gray-200">
                    {{ $internships->appends(request()->query())->links() }}
                </div>
                @endif
                
            @else
                <!-- No Results -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-10 text-center">
                        <div class="mx-auto w-24 h-24 flex items-center justify-center rounded-full bg-indigo-50 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No internships found</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">We couldn't find any internships matching "{{ $search }}"</p>
                        
                        <div class="max-w-md mx-auto bg-gray-50 rounded-lg p-5 border border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Search Tips
                            </h4>
                            <ul class="text-sm text-gray-600 space-y-2 text-left">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Try using more general keywords
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Check your spelling
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Try searching for related skills or job titles
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mt-8">
                            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-indigo-500 text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Browse all internships
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>