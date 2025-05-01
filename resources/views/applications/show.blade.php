<x-app-layout>
    <!-- Page Header with Internship Context -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <span>{{ $application->internship->title }}</span>
                <span class="mx-2 text-gray-400">|</span>
                <span class="text-base font-normal text-gray-600">{{ $application->internship->employer->employer_name }}</span>
            </h2>
            <div>
                @if(auth()->user()->isEmployer())
                    <a href="{{ route('myinternship.show', $application->internship) }}"
                        class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        View Internship Details
                    </a>
                @else
                    <a href="{{ route('internship.show', $application->internship) }}"
                        class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        View Internship Details
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message with Animation -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm animate__animated animate__fadeIn">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Add this near the top of the page, right after the success message section -->
@if(session('error'))
    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm animate__animated animate__fadeIn">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            {{ session('error') }}
        </div>
    </div>
@endif

            <!-- Applicant Header - Employer View -->
            @if(auth()->user()->isEmployer() || auth()->user()->isAdmin())
                <div class="sticky top-0 z-30 bg-white shadow-sm rounded-lg p-6 border border-gray-100 transform transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                        <div class="flex items-center space-x-4">
                            @if($application->profile_photo_path)
                                <div class="flex-shrink-0 relative group">
                                    <img src="{{ Storage::url($application->profile_photo_path) }}" alt="{{ $application->user->name }}" 
                                         class="h-14 w-14 rounded-full object-cover border-2 border-gray-200 shadow-sm
                                                transition-all duration-300 group-hover:border-indigo-300 group-hover:shadow-md">
                                </div>
                            @else
                                <div class="flex-shrink-0">
                                    <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-semibold">
                                        {{ substr($application->user->name, 0, 1) }}
                                    </div>
                                </div>
                            @endif
                            <div>
                                <h1 class="text-xl font-semibold text-gray-800">
                                    {{ $application->user->name }}
                                </h1>
                                <div class="flex items-center mt-1 space-x-3">
                                    @php
                                        $statusClass = match($application->status) {
                                            'accepted' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'interviewed' => 'bg-blue-100 text-blue-800',
                                            'reviewing' => 'bg-yellow-100 text-yellow-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $application->statusLabel }}
                                    </span>
                                    <span>
                                        Applied {{ $application->created_at->format('M j, Y') }}
                                        <span class="text-gray-400">&middot;</span>
                                        {{ $application->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Action Buttons -->
                        <div class="lg:mb-0 flex items-center space-x-2">
                            <a href="tel:{{ $application->phone }}" 
                               class="bg-gray-100 p-2 rounded-full hover:bg-gray-200 text-gray-700 transition-colors"
                               title="Call Applicant">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </a>
                            <a href="mailto:{{ $application->user->email }}" 
                               class="bg-gray-100 p-2 rounded-full hover:bg-gray-200 text-gray-700 transition-colors"
                               title="Email Applicant">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mt-6">
                        <div class="flex-grow w-full sm:w-auto">
                            <form method="POST" action="{{ route('applications.update-status', $application) }}"
                                class="flex flex-col sm:flex-row gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status"
                                    class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 pr-10">
                                    <option value="">Change Status</option>
                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                    <option value="interviewed" {{ $application->status == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accept</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                </select>
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors duration-200 inline-flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Status
                                </button>
                            </form>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="mailto:{{ $application->user->email }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email Applicant
                            </a>
                            <a href="{{ route('applications.index', ['internship_id' => $application->internship_id]) }}"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                All Applications
                            </a>
                        </div>
                    </div>
                </div>

            <!-- Applicant Header - Student View -->
            @else
                <div class="sticky top-0 z-30 bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            @if($application->profile_photo_path)
                                <div class="mr-4 flex-shrink-0">
                                    <img src="{{ Storage::url($application->profile_photo_path) }}" alt="{{ $application->user->name }}" 
                                        class="h-16 w-16 rounded-full object-cover border-2 border-gray-200 shadow-sm">
                                </div>
                            @endif
                            <div>
                                <h1 class="text-xl font-semibold text-gray-800">
                                    Your Application
                                </h1>
                                <div class="mt-2 flex flex-wrap items-center gap-3">
                                    @php
                                        $statusClass = match($application->status) {
                                            'accepted' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'interviewed' => 'bg-blue-100 text-blue-800',
                                            'reviewing' => 'bg-yellow-100 text-yellow-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $application->statusLabel }}
                                    </span>
                                        Submitted {{ $application->created_at->format('M j, Y') }}
                                        <span class="text-gray-400">&middot;</span>
                                        {{ $application->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Replace the current withdraw form in the Student View section with this enhanced version -->
@if($application->status === 'pending' || $application->status === 'reviewing')
    <div class="flex-shrink-0">
        <form id="withdrawForm" action="{{ route('applications.destroy', $application) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" 
                  onclick="confirmWithdraw('{{ $application->status }}')"
                  class="bg-red-50 text-red-600 px-3 py-2 rounded-md hover:bg-red-100 transition-colors duration-200 text-sm font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Withdraw Application
            </button>
        </form>
    </div>

   
@endif
                    </div>
                </div>
            @endif

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Left Column: Applicant Info -->
                <div class="lg:col-span-1">
                    <div class="lg:sticky" style="top: 6rem; max-height: calc(100vh - 8rem); overflow-y: auto;">
                        <!-- Applicant Information Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Applicant Information
                                </h3>
                                
                                @if($application->profile_photo_path)
                                <div class="mb-6 flex justify-center">
                                    <img src="{{ Storage::url($application->profile_photo_path) }}" 
                                        alt="{{ $application->user->name }}"
                                        class="h-36 w-36 rounded-full object-cover border-2 border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                </div>
                                @endif

                                <div class="space-y-4 divide-y divide-gray-100">
                                    <div class="py-3">
                                        <p class="text-sm font-medium text-gray-500">Full Name</p>
                                        <p class="mt-1 font-medium text-gray-900">{{ $application->user->name }}</p>
                                    </div>

                                    <div class="py-3">
                                        <p class="text-sm font-medium text-gray-500">Email Address</p>
                                        <p class="mt-1 font-medium text-gray-900">
                                            <a href="mailto:{{ $application->user->email }}" class="text-indigo-600 hover:text-indigo-800">
                                                {{ $application->user->email }}
                                            </a>
                                        </p>
                                    </div>

                                    <div class="py-3">
                                        <p class="text-sm font-medium text-gray-500">Phone Number</p>
                                        <p class="mt-1 font-medium text-gray-900">
                                            @if($application->phone)
                                                <a href="tel:{{ $application->phone }}" class="text-indigo-600 hover:text-indigo-800">
                                                    {{ $application->phone }}
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">Not provided</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="py-3">
                                        <p class="text-sm font-medium text-gray-500">Available to Start</p>
                                        <p class="mt-1 font-medium text-gray-900">
                                            @if($application->availability)
                                                {{ date('F j, Y', strtotime($application->availability)) }}
                                                <span class="text-gray-400 text-sm">({{ \Carbon\Carbon::parse($application->availability)->diffForHumans() }})</span>
                                            @else
                                                <span class="text-gray-400 italic">Not specified</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="py-3">
                                        <p class="text-sm font-medium text-gray-500">Education Level</p>
                                        <p class="mt-1 font-medium text-gray-900">
                                            {{ ucfirst(str_replace('_', ' ', $application->education)) ?? 'Not specified' }}
                                        </p>
                                    </div>

                                    <div class="py-3">
                                        <p class="text-sm font-medium text-gray-500">Institution</p>
                                        <p class="mt-1 font-medium text-gray-900">{{ $application->institution ?? 'Not specified' }}</p>
                                    </div>

                                    <div class="py-3">
                                        <p class="text-sm font-medium text-gray-500">Field of Study</p>
                                        <p class="mt-1 font-medium text-gray-900">{{ $application->field_of_study ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Employer Notes Card (Employer Only) -->
                        @if(auth()->user()->isEmployer() || auth()->user()->isAdmin())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Private Notes
                                </h3>

                                <form method="POST" action="{{ route('applications.update-notes', $application) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4">
                                        <textarea name="notes" rows="4"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                            placeholder="Add private notes about this applicant...">{{ $application->notes }}</textarea>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Notes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        <!-- Application Timeline -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Application Timeline
                                </h3>

                                <div class="relative pl-6 border-l-2 border-gray-200 space-y-6 py-2">
                                    <!-- Application Created -->
                                    <div class="relative">
                                        <div class="absolute -left-[25px] mt-1.5 h-4 w-4 rounded-full bg-indigo-500 border-2 border-white"></div>
                                        <p class="text-sm font-medium text-gray-900">Application Submitted</p>
                                        <p class="text-xs text-gray-500">{{ $application->created_at->format('M j, Y - g:ia') }}</p>
                                    </div>
                                    
                                    <!-- Status Changes -->
                                    @if($application->status !== 'pending')
                                        <div class="relative">
                                            <div class="absolute -left-[25px] mt-1.5 h-4 w-4 rounded-full 
                                                @if($application->status === 'accepted') bg-green-500
                                                @elseif($application->status === 'rejected') bg-red-500
                                                @else bg-blue-500 @endif
                                                border-2 border-white"></div>
                                            <p class="text-sm font-medium text-gray-900">Status Changed to {{ ucfirst($application->status) }}</p>
                                            <p class="text-xs text-gray-500">{{ $application->updated_at->format('M j, Y - g:ia') }}</p>
                                        </div>
                                    @endif
                                    
                                    <!-- Interview Date if set -->
                                    @if($application->interview_date)
                                        <div class="relative">
                                            <div class="absolute -left-[25px] mt-1.5 h-4 w-4 rounded-full bg-purple-500 border-2 border-white"></div>
                                            <p class="text-sm font-medium text-gray-900">Interview Scheduled</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($application->interview_date)->format('M j, Y - g:ia') }}</p>
                                        </div>
                                    @endif
                                    
                                    <!-- Response Date if set -->
                                    @if($application->response_date)
                                        <div class="relative">
                                            <div class="absolute -left-[25px] mt-1.5 h-4 w-4 rounded-full 
                                                {{ $application->status === 'accepted' ? 'bg-green-500' : 'bg-red-500' }}
                                                border-2 border-white"></div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $application->status === 'accepted' ? 'Application Accepted' : 'Application Rejected' }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($application->response_date)->format('M j, Y - g:ia') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Application Details -->
                <div class="lg:col-span-2">
                    <!-- Skills Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Skills & Expertise
                            </h3>

                            @if($application->skills)
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $application->skills) as $skill)
                                        <span class="bg-indigo-50 text-indigo-700 text-sm font-medium px-3 py-1 rounded-full">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center justify-center h-24 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500">No skills listed</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Documents Card with Modern Layout -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Documents
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($application->resume_path)
                                    <a href="{{ route('applications.download', ['application' => $application, 'type' => 'resume']) }}"
                                        class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-indigo-300 transition-all duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 flex items-center justify-center bg-red-100 text-red-600 rounded-lg mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">Resume</p>
                                                    <p class="text-sm text-gray-500">PDF Document</p>
                                                </div>
                                            </div>
                                            <div class="flex space-x-3">
                                                <span class="text-indigo-600 flex items-center group">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 transition-transform group-hover:-translate-y-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    <span class="group-hover:underline">Download</span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endif

                                @if($application->transcript_path)
                                    <a href="{{ route('applications.download', ['application' => $application, 'type' => 'transcript']) }}"
                                        class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-indigo-300 transition-all duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">Transcript</p>
                                                    <p class="text-sm text-gray-500">PDF Document</p>
                                                </div>
                                            </div>
                                            <div class="flex space-x-3">
                                                <span class="text-indigo-600 flex items-center group">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 transition-transform group-hover:-translate-y-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    <span class="group-hover:underline">Download</span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endif

                                @if(!$application->resume_path && !$application->transcript_path)
                                    <div class="col-span-2 text-center py-10 bg-gray-50 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-3"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        <p class="text-gray-500">No documents were uploaded with this application</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Cover Letter with Styled Content -->
                    <!-- Cover Letter with Styled Content and Read More Toggle -->
                    <!-- Cover Letter -->
@if($application->cover_letter)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Cover Letter
            </h3>
            <div x-data="{ expanded: false }">
                <div class="prose max-w-none border-l-4 border-indigo-100 pl-4 py-1 text-gray-700 break-words whitespace-normal overflow-wrap-break-word"
                     :class="{'line-clamp-6 max-h-48 overflow-hidden': !expanded}">
                    {!! nl2br(e($application->cover_letter)) !!}
                </div>
                @if(strlen($application->cover_letter) > 500)
                    <button @click="expanded = !expanded" 
                            class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                        <span x-text="expanded ? 'Show less' : 'Read more'">Read more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" 
                             :class="{'rotate-180': expanded}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                @endif
            </ rivalry>
        </div>
    </div>
@endif

<!-- Why Interested -->
@if($application->why_interested)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Why Interested
            </h3>
            <div x-data="{ expanded: false }">
                <div class="prose max-w-none border-l-4 border-indigo-100 pl-4 py-1 text-gray-700 break-words whitespace-normal overflow-wrap-break-word"
                     :class="{'line-clamp-6 max-h-48 overflow-hidden': !expanded}">
                    {!! nl2br(e($application->why_interested)) !!}
                </div>
                @if(strlen($application->why_interested) > 500)
                    <button @click="expanded = !expanded" 
                            class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                        <span x-text="expanded ? 'Show less' : 'Read more'">Read more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" 
                             :class="{'rotate-180': expanded}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif
                </div>
            </div>
        </div>
    </div>

     <!-- Add this script at the bottom of your page -->
     <script>
        function confirmWithdraw(status) {
            let message = 'Are you sure you want to withdraw this application? This action cannot be undone.';
            
            if (status === 'reviewing') {
                message = 'Warning: This application is currently being reviewed by the employer. ' + 
                         'Withdrawing now may affect your chances for future applications with this company. ' +
                         'Are you sure you want to proceed?';
            }
            
            if (confirm(message)) {
                document.getElementById('withdrawForm').submit();
            }
        }
    </script>
</x-app-layout>