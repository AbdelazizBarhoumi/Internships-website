<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Internship Details
                </h2>
                <p class="text-sm text-gray-600">ID: #{{ $internship->id }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('internship.show', $internship->id) }}" target="_blank"
                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Public Page
                </a>
                <a href="{{ route('admin.internships') }}"
                    class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Internships
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md flex justify-between items-center" role="alert">
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="text-green-700" onclick="this.parentElement.remove()">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md flex justify-between items-center" role="alert">
                    <div>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="text-red-700" onclick="this.parentElement.remove()">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Status Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 flex justify-between items-center border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <div>
                            <span class="text-xs text-gray-500">Status</span>
                            <div class="flex items-center mt-1">
                                @if($internship->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm flex items-center">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm flex items-center">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="border-l border-gray-200 h-8"></div>
                        
                        <div>
                            <span class="text-xs text-gray-500">Deadline</span>
                            <div class="mt-1">
                                @php 
                                
                                    $deadline = \Carbon\Carbon::parse($internship->deadline_date);
                                    $daysLeft = round(now()->floatDiffInDays($deadline));
                                    $isPast = $deadline->isPast();
                                @endphp
                                <span class="{{ $isPast ? 'text-red-600' : ($daysLeft <= 7 ? 'text-orange-600' : 'text-gray-900') }} text-sm font-medium">
                                    {{ $deadline->format('M d, Y') }}
                                    @if(!$isPast)
                                        <span class="text-xs ml-1">({{ $daysLeft }} days left)</span>
                                    @else
                                        <span class="text-xs ml-1">(expired)</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <form action="{{ route('admin.internships.toggle-status', $internship) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="{{ $internship->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} px-3 py-1 rounded-md text-sm font-medium transition-colors">
                                {{ $internship->is_active ? 'Deactivate' : 'Activate' }} Internship
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Internship Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-3">
                    <h2 class="text-lg font-medium text-gray-900">Internship Details</h2>
                </div>
                
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $internship->title }}</h1>
                            <div class="flex items-center mt-1">
                                <a href="{{ route('admin.users.show', $internship->employer->user) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $internship->employer->employer_name }}
                                </a>
                                <span class="mx-2 text-gray-500">•</span>
                                <span class="text-gray-600">{{ $internship->location }}</span>
                                @if($internship->remote_available)
                                    <span class="ml-2 px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">Remote Available</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-3 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Position Details
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                                    
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <span class="text-sm font-medium text-gray-500">Duration</span>
                                        <p class="mt-1">{{ $internship->duration }}</p>
                                    </div>
                                
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <span class="text-sm font-medium text-gray-500">Posted Date</span>
                                        <p class="mt-1">{{ $internship->created_at->format('F j, Y') }}</p>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-md font-medium mb-2">Tags</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($internship->tags as $tag)
                                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                                                {{ $tag->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-500">No tags</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
@if ($internship->description)
<div class="mb-8">
                                <h3 class="text-lg font-semibold mb-3 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    Description
                                </h3>
                                <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
                                    {!! nl2br(e($internship->description)) !!}
                                </div>
                            </div>
@endif
                        </div>
                        
                        <div>
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <h3 class="text-md font-semibold mb-3">Application Statistics</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Total Applications:</span>
                                        <span class="font-medium">{{ $internship->applications->count() }}</span>
                                    </div>
                                    
                                    @php
                                        $statuses = ['pending', 'reviewing', 'interviewed', 'accepted', 'rejected'];
                                        $statusCounts = [];
                                        foreach ($statuses as $status) {
                                            $statusCounts[$status] = $internship->applications->where('status', $status)->count();
                                        }
                                    @endphp
                                    
                                    @foreach($statusCounts as $status => $count)
                                        @if($count > 0)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">{{ ucfirst($status) }}:</span>
                                                <span class="font-medium">{{ $count }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Employer Card -->
                            <div class="border rounded-lg overflow-hidden mb-6">
                                <div class="border-b bg-gray-50 px-4 py-3 flex justify-between items-center">
                                    <h3 class="font-medium text-gray-700">Employer Details</h3>
                                    <a href="{{ route('admin.users.show', $internship->employer->user) }}" class="text-xs text-blue-600 hover:underline">
                                        View Full Profile
                                    </a>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold">
                                            {{ substr($internship->employer->employer_name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium">{{ $internship->employer->employer_name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $internship->employer->industry }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm">
                                        @if ($internship->employer->location )
                                        <div class="flex">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $internship->employer->location }}</span>
                                        </div>
                                        @endif
                                        
                                        <div class="flex">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <a href="mailto:{{ $internship->employer->employer_email }}" class="text-blue-600 hover:underline">
                                                {{ $internship->employer->employer_email }}
                                            </a>
                                        </div>
                                        @if($internship->employer->phone)
                                            <div class="flex">
                                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <span>{{ $internship->employer->phone }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2">
                                <button type="button" class="w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 flex items-center justify-center"
                                    onclick="document.getElementById('deleteModal').classList.remove('hidden')">
                                    <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Internship
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-3 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Applications</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $internship->applications->count() }} Total
                    </span>
                </div>
                
                <div class="p-6">
                    @if($internship->applications->count() > 0)
                        <div class="mb-4 flex space-x-2">
                            @foreach(['all', 'pending', 'reviewing', 'interviewed', 'accepted', 'rejected'] as $statusFilter)
                                <button 
                                    class="px-3 py-1 text-sm rounded-full status-filter {{ $statusFilter === 'all' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700' }}"
                                    data-status="{{ $statusFilter }}">
                                    {{ ucfirst($statusFilter) }}
                                </button>
                            @endforeach
                        </div>
                    
                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applicant
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applied On
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Last Updated
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                       Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($internship->applications as $application)
                                        <tr class="application-row" data-status="{{ $application->status }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600">
                                                        {{ substr($application->user->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <a href="{{ route('admin.users.show', $application->user) }}"
                                                            class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                            {{ $application->user->name }}
                                                        </a>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $application->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full
                                                    {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $application->status === 'interviewed' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $application->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $application->created_at->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $application->updated_at->diffForHumans() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.applications.show', $application) }}"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                            <p class="mt-1 text-sm text-gray-500">No one has applied to this internship yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div id="updateStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Internship Status</h3>
                
            </div>
        </div>
    </div>

    <!-- Application Status Modal -->
    <div id="applicationStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Application Status</h3>
                <form id="applicationStatusForm" action="" method="POST" class="mt-4">
                    @csrf
                    <div class="mt-2 text-left">
                        <label for="app_status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="app_status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending">Pending</option>
                            <option value="reviewing">Reviewing</option>
                            <option value="interviewed">Interviewed</option>
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                                onclick="document.getElementById('applicationStatusModal').classList.add('hidden')">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Delete Internship</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete this internship? All data including applications will be permanently removed. This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-3">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"
                            onclick="document.getElementById('deleteModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <form action="{{ route('admin.internships.delete', $internship) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Application status filter
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilters = document.querySelectorAll('.status-filter');
            const applicationRows = document.querySelectorAll('.application-row');
            
            statusFilters.forEach(filter => {
                filter.addEventListener('click', function() {
                    // Remove active class from all filters
                    statusFilters.forEach(sf => {
                        sf.classList.remove('bg-blue-100', 'text-blue-800');
                        sf.classList.add('bg-gray-100', 'text-gray-700');
                    });
                    
                    // Add active class to current filter
                    this.classList.remove('bg-gray-100', 'text-gray-700');
                    this.classList.add('bg-blue-100', 'text-blue-800');
                    
                    const status = this.dataset.status;
                    
                    // Show/hide rows based on filter
                    applicationRows.forEach(row => {
                        if (status === 'all' || row.dataset.status === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
            
            // Update application status buttons
            const updateStatusBtns = document.querySelectorAll('.update-status-btn');
            updateStatusBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const applicationId = this.dataset.applicationId;
                    const currentStatus = this.dataset.currentStatus;
                    
                    // Set the form action
                    const form = document.getElementById('applicationStatusForm');
                    form.action = `/admin/applications/${applicationId}/status`;
                    
                    // Set the current status
                    document.getElementById('app_status').value = currentStatus;
                    
                    // Show the modal
                    document.getElementById('applicationStatusModal').classList.remove('hidden');
                });
            });
        });
    </script>
</x-app-layout>