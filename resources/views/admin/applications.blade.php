<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Internship Applications') }}
            </h2>
            <span class="text-sm text-gray-600">Total: {{ $applications->total() }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md flex justify-between items-center" role="alert">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="text-green-700" onclick="this.parentElement.remove()">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Enhanced Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Filter Applications</h3>
                    
                    <form action="{{ route('admin.applications') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                <option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label for="internship_id" class="block text-sm font-medium text-gray-700 mb-1">Internship</label>
                            <select name="internship_id" id="internship_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Internships</option>
                                @foreach(\App\Models\Internship::orderBy('title')->get() as $internship)
                                    <option value="{{ $internship->id }}" {{ request('internship_id') == $internship->id ? 'selected' : '' }}>
                                        {{ $internship->title }} ({{ $internship->employer->employer_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="employer_id" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                            <select name="employer_id" id="employer_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Companies</option>
                                @foreach(\App\Models\Employer::orderBy('employer_name')->get() as $employer)
                                    <option value="{{ $employer->id }}" {{ request('employer_id') == $employer->id ? 'selected' : '' }}>
                                        {{ $employer->employer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    placeholder="Name, Email, Skills..." 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @if(request('search'))
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                        <a href="{{ route('admin.applications', request()->except('search')) }}" class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="md:col-span-3 flex justify-between items-center mt-2">
                            <div class="flex space-x-2">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                    </svg>
                                    Apply Filters
                                </button>
                                
                                @if(request()->hasAny(['status', 'search', 'date_from', 'date_to', 'internship_id', 'employer_id']))
                                    <a href="{{ route('admin.applications') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                        </svg>
                                        Clear Filters
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Status Summary -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                @php
                    $statuses = ['all', 'pending', 'reviewing', 'interviewed', 'accepted', 'rejected'];
                    $statusCounts = [
                        'all' => $applications->total(), 
                        'pending' => \App\Models\Application::where('status', 'pending')->count(),
                        'reviewing' => \App\Models\Application::where('status', 'reviewing')->count(),
                        'interviewed' => \App\Models\Application::where('status', 'interviewed')->count(),
                        'accepted' => \App\Models\Application::where('status', 'accepted')->count(),
                        'rejected' => \App\Models\Application::where('status', 'rejected')->count(),
                    ];
                    
                    $statusColors = [
                        'all' => 'bg-blue-100 text-blue-800',
                        'pending' => 'bg-yellow-100 text-yellow-800', 
                        'reviewing' => 'bg-indigo-100 text-indigo-800',
                        'interviewed' => 'bg-purple-100 text-purple-800',
                        'accepted' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800'
                    ];
                @endphp
                
                @foreach($statuses as $status)
                    <a href="{{ route('admin.applications', array_merge(request()->except('status'), $status === 'all' ? [] : ['status' => $status])) }}"
                       class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ request('status') === $status ? 'ring-2 ring-blue-500' : '' }}">
                        <div class="p-4 text-center">
                            <div class="text-2xl font-bold {{ $statusColors[$status] }} rounded-full w-10 h-10 flex items-center justify-center mx-auto">
                                {{ substr(ucfirst($status), 0, 1) }}
                            </div>
                            <div class="mt-2 font-bold text-gray-900 text-xl">{{ $statusCounts[$status] }}</div>
                            <div class="text-sm text-gray-500">{{ $status === 'all' ? 'All Applications' : ucfirst($status) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <!-- Applications Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Application List</h3>
                        <div class="flex space-x-2 text-sm">
                            <span class="text-gray-600">
                                {{ $applications->firstItem() ?? 0 }}-{{ $applications->lastItem() ?? 0 }} of {{ $applications->total() }} applications
                            </span>
                        </div>
                    </div>
                    
                    @if($applications->count() > 0)
                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applicant
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Internship
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Company
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applied Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($applications as $application)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center bg-gray-200 text-gray-600 font-semibold">
                                                        {{ substr($application->user->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <a href="{{ route('admin.users.show', $application->user) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                            {{ $application->user->name }}
                                                        </a>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $application->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div>
                                                    <a href="{{ route('admin.internships.show', $application->internship) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ $application->internship->title }}
                                                    </a>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <span class="inline-block mr-2">
                                                            <svg class="inline-block h-3 w-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                            {{ $application->internship->location }}
                                                        </span>
                                                        <span>
                                                            <svg class="inline-block h-3 w-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ $application->internship->duration }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('admin.users.show', $application->internship->employer->user) }}" class="text-sm text-gray-900 hover:text-blue-600">
                                                    {{ $application->internship->employer->employer_name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                                    {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $application->status === 'reviewing' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                    {{ $application->status === 'interviewed' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Updated {{ $application->updated_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $application->created_at->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $application->created_at->format('g:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                                <div class="flex space-x-3">
                                                    <a href="{{ route('admin.applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    
            
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $applications->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="bg-white p-6 text-center border rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request()->hasAny(['status', 'search', 'date_from', 'date_to', 'internship_id', 'employer_id']))
                                    Try adjusting your filters or search criteria.
                                    <a href="{{ route('admin.applications') }}" class="text-blue-600 hover:underline font-medium">Clear all filters</a>
                                @else
                                    No applications have been submitted yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>