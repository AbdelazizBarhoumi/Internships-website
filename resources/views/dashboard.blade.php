<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(auth()->user()->isEmployer())
                <!-- Employer Dashboard -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Active Internships</h3>
                            <p class="text-3xl font-bold text-indigo-600">{{ auth()->user()->employer->internships->count() }}</p>
                            <a href="{{ route('internship.create') }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                Post a new internship
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Applications</h3>
                            <p class="text-3xl font-bold text-indigo-600">
                                {{ auth()->user()->employer->internships->sum(function($internship) { 
                                    return $internship->applications->count(); 
                                }) }}
                            </p>
                            <a href="{{ route('applications.index') }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                View all applications
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pending Review</h3>
                            <p class="text-3xl font-bold text-amber-500">
                                {{ auth()->user()->employer->internships->sum(function($internship) { 
                                    return $internship->applications()->where('status', 'pending')->count(); 
                                }) }}
                            </p>
                            <a href="{{ route('applications.index', ['status' => 'pending']) }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                Review applications
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Internships -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Your Internships</h3>
                            <a href="{{ route('internship.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300">
                                Post New
                            </a>
                        </div>
                        
                        @if(auth()->user()->employer->internships->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach(auth()->user()->employer->internships->sortByDesc('created_at')->take(5) as $internship)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="{{ route('myinternship.show', $internship) }}">{{ $internship->title }}</a>
                                                        </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">{{ $internship->location }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">{{ $internship->applications->count() }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <a href="{{ route('applications.index', ['internship_id' => $internship->id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                                    <a href="{{ route('myinternship.edit', $internship) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                                    <a href="{{ route('myinternship.destroy', $internship) }}" 
                                                       class="text-red-600 hover:text-red-900 mr-3" 
                                                       onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this internship?')) document.getElementById('delete-internship-{{ $internship->id }}').submit();">
                                                        Delete
                                                    </a>
                                                    <form id="delete-internship-{{ $internship->id }}" method="POST" action="{{ route('myinternship.destroy', $internship) }}" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(auth()->user()->employer->internships->count() > 5)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('home', ['employer' => true]) }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                        View all internships
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">You haven't posted any internships yet.</p>
                                <a href="{{ route('internship.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                                    Post Your First Internship
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
            @else
                <!-- Applicant Dashboard -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Your Applications</h3>
                            <p class="text-3xl font-bold text-indigo-600">{{ auth()->user()->applications->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pending</h3>
                            <p class="text-3xl font-bold text-amber-500">{{ auth()->user()->applications()->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Accepted</h3>
                            <p class="text-3xl font-bold text-green-600">{{ auth()->user()->applications()->where('status', 'accepted')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Applications</h3>
                        
                        @if(auth()->user()->applications->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Internship</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach(auth()->user()->applications->sortByDesc('created_at')->take(5) as $application)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <a href="{{ route('applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900">{{ $application->internship->title }}</a>
                                                    <div class="text-sm font-medium text-gray-900"></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">{{ $application->internship->employer->company_name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($application->status === 'accepted') 
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
                                                        {{ $application->statusLabel }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">You haven't applied for any internships yet.</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                                    Browse Internships
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Recommended Internships -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recommended Internships</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach(\App\Models\Internship::where('featured', true)->latest()->take(4)->get() as $internship)
                                <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                    <div class="p-4">
                                        <h4 class="font-semibold text-lg mb-1">{{ $internship->title }}</h4>
                                        <p class="text-gray-600 text-sm mb-2">{{ $internship->employer->company_name }} • {{ $internship->location }}</p>
                                        
                                        @if($internship->tags->count() > 0)
                                            <div class="flex flex-wrap gap-1 mt-2">
                                                @foreach($internship->randomTags(3) as $tag)
                                                    <x-tag :tag="$tag" size="small" />
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <div class="mt-4">
                                            <a href="{{ route('internship.show', $internship) }}" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                Browse all internships
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>