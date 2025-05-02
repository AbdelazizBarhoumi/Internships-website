<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('My Internship Applications') }}
            </h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('applications.my.index') }}" class="inline-flex items-center px-3 py-1 {{ !request('status') ? 'bg-indigo-100 text-indigo-800 font-medium' : 'bg-gray-100 text-gray-700' }} text-sm rounded-full transition hover:bg-indigo-50">
                    All <span class="ml-1 font-bold">{{ $pendingCount + $reviewingCount + $interviewedCount + $acceptedCount + $rejectedCount }}</span>
                </a>
                <a href="{{ route('applications.my.index', ['status' => 'pending']) }}" class="inline-flex items-center px-3 py-1 {{ request('status') === 'pending' ? 'bg-blue-100 text-blue-800 font-medium' : 'bg-gray-100 text-gray-700' }} text-sm rounded-full transition hover:bg-blue-50">
                    Pending <span class="ml-1 font-bold text-blue-600">{{ $pendingCount }}</span>
                </a>
                <a href="{{ route('applications.my.index', ['status' => 'reviewing']) }}" class="inline-flex items-center px-3 py-1 {{ request('status') === 'reviewing' ? 'bg-purple-100 text-purple-800 font-medium' : 'bg-gray-100 text-gray-700' }} text-sm rounded-full transition hover:bg-purple-50">
                    Reviewing <span class="ml-1 font-bold text-purple-600">{{ $reviewingCount }}</span>
                </a>
                <a href="{{ route('applications.my.index', ['status' => 'interviewed']) }}" class="inline-flex items-center px-3 py-1 {{ request('status') === 'interviewed' ? 'bg-teal-100 text-teal-800 font-medium' : 'bg-gray-100 text-gray-700' }} text-sm rounded-full transition hover:bg-teal-50">
                    Interviewed <span class="ml-1 font-bold text-teal-600">{{ $interviewedCount }}</span>
                </a>
                <a href="{{ route('applications.my.index', ['status' => 'accepted']) }}" class="inline-flex items-center px-3 py-1 {{ request('status') === 'accepted' ? 'bg-green-100 text-green-800 font-medium' : 'bg-gray-100 text-gray-700' }} text-sm rounded-full transition hover:bg-green-50">
                    Accepted <span class="ml-1 font-bold text-green-600">{{ $acceptedCount }}</span>
                </a>
                <a href="{{ route('applications.my.index', ['status' => 'rejected']) }}" class="inline-flex items-center px-3 py-1 {{ request('status') === 'rejected' ? 'bg-red-100 text-red-800 font-medium' : 'bg-gray-100 text-gray-700' }} text-sm rounded-full transition hover:bg-red-50">
                    Rejected <span class="ml-1 font-bold text-red-600">{{ $rejectedCount }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Application Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <!-- All Applications Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-l-4 {{ !request('status') ? 'border-indigo-400' : 'border-gray-200' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 {{ !request('status') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">All Applications</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $pendingCount + $reviewingCount + $interviewedCount + $acceptedCount + $rejectedCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Applications Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-l-4 {{ request('status') === 'pending' ? 'border-blue-400' : 'border-gray-200' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 {{ request('status') === 'pending' ? 'text-blue-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $pendingCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviewing Applications Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-l-4 {{ request('status') === 'reviewing' ? 'border-purple-400' : 'border-gray-200' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 {{ request('status') === 'reviewing' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Reviewing</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $reviewingCount + $interviewedCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accepted Applications Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-l-4 {{ request('status') === 'accepted' ? 'border-green-400' : 'border-gray-200' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 {{ request('status') === 'accepted' ? 'text-green-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Accepted</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $acceptedCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected Applications Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-l-4 {{ request('status') === 'rejected' ? 'border-red-400' : 'border-gray-200' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 {{ request('status') === 'rejected' ? 'text-red-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Rejected</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $rejectedCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Sort Controls -->
            <div class="mb-6">
                <form action="{{ route('applications.my.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by internship title or company..." 
                            class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="sort" class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Oldest First</option>
                            <option value="company_asc" {{ request('sort') == 'company_asc' ? 'selected' : '' }}>Company (A-Z)</option>
                            <option value="company_desc" {{ request('sort') == 'company_desc' ? 'selected' : '' }}>Company (Z-A)</option>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Filter
                    </button>
                    @if(request('search') || request('sort'))
                        <a href="{{ request()->has('status') ? route('applications.my.index', ['status' => request('status')]) : route('applications.my.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear Filters
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($applications->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No applications found</h3>
                            @if(request('status') || request('search'))
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                                <div class="mt-6">
                                    <a href="{{ route('applications.my.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Clear Filters
                                    </a>
                                </div>
                            @else
                                <p class="mt-1 text-sm text-gray-500">You haven't applied for any internships yet.</p>
                                <div class="mt-6">
                                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Browse Internships
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Internship
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Company
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applied On
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($applications as $application)
    <tr class="hover:bg-gray-50 {{ !$application->internship->employer->user->is_active ? 'bg-gray-50' : '' }}">
        <td class="px-6 py-4 whitespace-normal">
            @if($application->internship->employer->user->is_active)
                <div class="text-sm font-medium text-gray-900">
                    <a href="{{ route('internship.show', $application->internship) }}" class="hover:text-indigo-600">
                        {{ $application->internship->title }}
                    </a>
                </div>
            @else
                <div class="text-sm font-medium text-gray-500">
                    {{ dd($application->internship->employer) }}
                    {{ $application->internship->title }}
                </div>
                <div class="text-xs text-red-500">
                    Employer account inactive
                </div>
            @endif
            <div class="text-sm text-gray-500 flex items-center mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ Str::limit($application->internship->location, 30) }}
            </div>
        </td>
        <td class="px-6 py-4">
            <div class="flex items-center">
                @if($application->internship->employer->employer_logo)
                    <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full object-cover {{ !$application->internship->employer->user->is_active ? 'opacity-50' : '' }}" 
                            src="{{ Storage::url($application->internship->employer->employer_logo) }}" 
                            alt="{{ $application->internship->employer->employer_name }}">
                    </div>
                @else
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center {{ !$application->internship->employer->user->is_active ? 'opacity-50' : '' }}">
                        <span class="text-gray-500 font-medium">{{ substr($application->internship->employer->employer_name, 0, 1) }}</span>
                    </div>
                @endif
                <div class="ml-4">
                    <div class="text-sm font-medium {{ $application->internship->employer->user->is_active ? 'text-gray-900' : 'text-gray-500' }}">
                        {{ $application->internship->employer->employer_name }}
                    </div>
                    <div class="text-xs text-gray-500">
                    {{ $application->internship->employer->industry ?? 'Not specified' }}
                    </div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4">
            <div class="text-sm text-gray-900">
                {{ $application->created_at->format('M j, Y') }}
            </div>
            <div class="text-xs text-gray-500">
                {{ $application->created_at->diffForHumans() }}
            </div>
        </td>
        <td class="px-6 py-4">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                          @if(!$application->internship->employer->user->is_active)
                              bg-gray-100 text-gray-800
                          @elseif($application->status === 'accepted') 
                              bg-green-100 text-green-800
                          @elseif($application->status === 'rejected')
                              bg-red-100 text-red-800
                          @elseif($application->status === 'interviewed')
                              bg-blue-100 text-blue-800
                          @elseif($application->status === 'reviewing')
                              bg-yellow-100 text-yellow-800
                          @else
                              bg-gray-100 text-gray-800
                          @endif">
                {{ !$application->internship->employer->user->is_active ? 'Employer Inactive' : $application->statusLabel }}
            </span>
            @if($application->last_status_change && $application->internship->employer->user->is_active)
                <div class="text-xs text-gray-500 mt-1">
                    Updated {{ $application->last_status_change->diffForHumans() }}
                </div>
            @endif
        </td>
        <td class="px-6 py-4 text-sm font-medium">
            <div class="flex space-x-2">
                <a href="{{ route('applications.show', $application) }}" 
                    class="text-indigo-600 hover:text-indigo-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View {{ !$application->internship->employer->user->is_active ? 'Details' : '' }}
                </a>
                
                @if(!in_array($application->status, ['accepted', 'rejected', 'withdrawn']) && $application->internship->employer->user->is_active)
                    <form action="{{ route('applications.destroy', $application) }}" method="POST" 
                        onsubmit="return confirm('Are you sure you want to withdraw this application? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Withdraw
                        </button>
                    </form>
                @endif
            </div>
        </td>
    </tr>
@endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $applications->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>