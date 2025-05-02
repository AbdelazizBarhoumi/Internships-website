<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Application Details
                </h2>
                <p class="text-sm text-gray-600">ID: #{{ $application->id }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.applications') }}"
                    class="px-3 py-1 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Applications
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex justify-between items-center"
                    role="alert">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="text-green-700" onclick="this.parentElement.remove()">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md flex justify-between items-center"
                    role="alert">
                    <span>{{ session('error') }}</span>
                    <button type="button" class="text-red-700" onclick="this.parentElement.remove()">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Application Overview Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between gap-6">
                        <!-- Left column -->
                        <div class="flex-1">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-xl font-bold text-gray-600 shrink-0">
                                    {{ substr($application->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h1 class="text-xl font-bold text-gray-900">{{ $application->user->name }}</h1>
                                    <p class="text-sm text-gray-500">{{ $application->user->email }}</p>

                                    <div class="mt-2 flex flex-wrap items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $application->status === 'interviewed' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                        <span class="text-gray-500 text-xs">
                                            Applied {{ $application->created_at->format('M j, Y') }} at {{ $application->created_at->format('g:i A') }}
                                        </span>
                                        <span class="text-gray-500 text-xs">
                                            ({{ $application->created_at->diffForHumans() }})
                                        </span>
                                    </div>

                                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Member Since</p>
                                            <p class="text-sm font-medium">{{ $application->user->created_at->format('M j, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Total Applications</p>
                                            <p class="text-sm font-medium">{{ $application->user->applications()->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right column -->
                        <div class="flex-1">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h2 class="font-medium mb-2 text-gray-700">
                                    <a href="{{ route('admin.internships.show', $application->internship) }}"
                                        class="hover:text-blue-700">
                                        {{ $application->internship->title }}
                                    </a>
                                </h2>
                                <div class="flex items-center mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                    </svg>
                                    <span class="text-sm">
                                        <a href="{{ route('admin.users.show', $application->internship->employer->user) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $application->internship->employer->employer_name }}
                                        </a>
                                    </span>
                                </div>
                                <div class="flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">{{ $application->internship->location }}</span>

                                    @if($application->internship->schedule)
                                        <span
                                            class="ml-2 px-2 py-0.5 bg-indigo-100 text-indigo-800 rounded-full text-xs">{{ $application->internship->schedule }}</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">Duration: {{ $application->internship->duration ?? 'Not specified' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="mt-10 flex flex-wrap justify-between gap-4">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.users.show', $application->user) }}"
                                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 005 10a6 6 0 0012 0c0-.81-.162-1.58-.452-2.287A5 5 0 0010 11z"
                                        clip-rule="evenodd" />
                                </svg>
                                View Applicant
                            </a>
                        
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.internships.show', $application->internship) }}"
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                                View Internship
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Student Information -->
                    @if($application->user->student)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="border-b border-gray-200 bg-gray-50">
                            <div class="px-6 py-3 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Student Information</h3>
                                <a href="{{ route('admin.users.show', $application->user) }}" class="text-sm text-blue-600 hover:underline">
                                    View Full Profile
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-medium text-gray-900">Education</h4>
                                    <div class="mt-2 space-y-3">
                                        <div>
                                            <p class="text-sm text-gray-500">Education Level</p>
                                            <p class="text-sm font-medium">{{ $application->user->student->education_level ?? 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Institution</p>
                                            <p class="text-sm font-medium">{{ $application->user->student->institution ?? 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Field of Study</p>
                                            <p class="text-sm font-medium">{{ $application->user->student->field_of_study ?? 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Graduation Year</p>
                                            <p class="text-sm font-medium">{{ $application->user->student->graduation_date ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-medium text-gray-900">Skills & Experience</h4>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-2">Skills</p>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse(explode(',', $application->user->student->skills ?? '') as $skill)
                                                @if(trim($skill))
                                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endif
                                            @empty
                                                <p class="text-sm text-gray-500">No skills listed</p>
                                            @endforelse
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Cover Letter -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="border-b border-gray-200 bg-gray-50">
                            <div class="px-6 py-3">
                                <h3 class="text-lg font-semibold text-gray-900">Cover Letter</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="prose max-w-none bg-gray-50 p-6 rounded-lg text-gray-700">
                                {!! nl2br(e($application->cover_letter)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Similar Applications -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="border-b border-gray-200 bg-gray-50">
                            <div class="px-6 py-3">
                                <h3 class="text-lg font-semibold text-gray-900">Other Applications</h3>
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">From This Applicant</h4>

                            @php
                                $otherApplications = $application->user->applications()
                                    ->where('id', '!=', $application->id)
                                    ->latest()
                                    ->take(3)
                                    ->get();
                            @endphp

                            @if($otherApplications->count() > 0)
                                <div class="space-y-3">
                                    @foreach($otherApplications as $otherApp)
                                        <a href="{{ route('admin.applications.show', $otherApp) }}"
                                            class="block p-3 border rounded-lg hover:bg-gray-50">
                                            <div class="flex justify-between">
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $otherApp->internship->title }}</span>
                                                <span
                                                    class="text-xs px-2 py-0.5 rounded-full
                                                            {{ $otherApp->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                            {{ $otherApp->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                            {{ $otherApp->status === 'interviewed' ? 'bg-purple-100 text-purple-800' : '' }}
                                                            {{ $otherApp->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                            {{ $otherApp->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($otherApp->status) }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">Applied
                                                {{ $otherApp->created_at->format('M j, Y') }}</div>
                                        </a>
                                    @endforeach
                                </div>
                                @if($application->user->applications()->where('id', '!=', $application->id)->count() > 3)
                                    <div class="mt-2 text-right">
                                        <a href="{{ route('admin.applications') }}?user_id={{ $application->user_id }}" class="text-sm text-blue-600 hover:underline">
                                            View all applications
                                        </a>
                                    </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-500">No other applications from this applicant.</p>
                            @endif

                            <h4 class="text-sm font-medium text-gray-700 mt-6 mb-2">For This Internship</h4>

                            @php
                                $internshipApplications = $application->internship->applications()
                                    ->where('id', '!=', $application->id)
                                    ->latest()
                                    ->take(3)
                                    ->get();
                            @endphp

                            @if($internshipApplications->count() > 0)
                                <div class="space-y-3">
                                    @foreach($internshipApplications as $intApp)
                                        <a href="{{ route('admin.users.show', $intApp->user)  }}"
                                            class="block p-3 border rounded-lg hover:bg-gray-50">
                                            <div class="flex justify-between">
                                                <span class="text-sm font-medium text-gray-900">{{ $intApp->user->name }}</span>
                                                <span
                                                    class="text-xs px-2 py-0.5 rounded-full
                                                            {{ $intApp->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                            {{ $intApp->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                            {{ $intApp->status === 'interviewed' ? 'bg-purple-100 text-purple-800' : '' }}
                                                            {{ $intApp->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                            {{ $intApp->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($intApp->status) }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">Applied
                                                {{ $intApp->created_at->format('M j, Y') }}</div>
                                        </a>
                                    @endforeach
                                </div>
                                @if($application->internship->applications()->where('id', '!=', $application->id)->count() > 3)
                                    <div class="mt-2 text-right">
                                        <a href="{{ route('admin.applications') }}?internship_id={{ $application->internship_id }}" class="text-sm text-blue-600 hover:underline">
                                            View all applications
                                        </a>
                                    </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-500">No other applications for this internship.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Admin Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="border-b border-gray-200 bg-gray-50">
                            <div class="px-6 py-3">
                                <h3 class="text-lg font-semibold text-gray-900">Admin Actions</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @if($application->resume_path)
                                    <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Download Resume/CV
                                    </a>
                                @endif

                                <hr class="my-4">

                                <button type="button"
                                    onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Delete Application
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="border-b border-gray-200 bg-gray-50">
                            <div class="px-6 py-3">
                                <h3 class="text-lg font-semibold text-gray-900">Admin Notes</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.applications.update-notes', $application) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="admin_notes" class="sr-only">Notes</label>
                                    <textarea id="admin_notes" name="admin_notes" rows="5"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        placeholder="Add private notes about this application...">{{ $application->admin_notes }}</textarea>
                                </div>
                                <div class="mt-2 flex justify-between items-center">
                                    <p class="text-xs text-gray-500">These notes are only visible to administrators.</p>
                                    <button type="submit"
                                        class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                        Save Notes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Application Status Information & Timeline -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="border-b border-gray-200 bg-gray-50">
                            <div class="px-6 py-3 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Application Status</h3>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $application->status === 'interviewed' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="mb-6">
                                <div class="relative">
                                    <!-- Timeline -->
                                    <div class="absolute h-full w-0.5 bg-gray-200 left-5"></div>

                                    <!-- Initial Application -->
                                    <div class="mb-6 ml-12 relative">
                                        <div class="absolute -left-7 mt-1.5">
                                            <div class="h-3 w-3 rounded-full border-2 border-blue-500 bg-white"></div>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium">Application Submitted</h4>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                {{ $application->created_at->format('F j, Y g:i A') }}</p>
                                            <div class="mt-2 text-sm bg-blue-50 px-3 py-2 rounded">
                                                <p>{{ $application->user->name }} applied for
                                                    {{ $application->internship->title }} at
                                                    {{ $application->internship->employer->employer_name }}.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-lg font-medium text-red-700">Delete Application</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500"
                        onclick="document.getElementById('deleteModal').classList.add('hidden')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-4">
                    <div class="flex items-center mb-4">
                        <svg class="h-12 w-12 text-red-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">Are you sure?</h4>
                            <p class="text-sm text-gray-500">This action cannot be undone.</p>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mb-6">
                        You're about to permanently delete this application. This will remove all records of this
                        application including status history and communications.
                    </p>
                </div>

                <form action="{{ route('admin.applications.destroy', $application) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="mt-2">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="confirm_delete" name="confirm_delete" type="checkbox" required
                                    class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="confirm_delete" class="font-medium text-gray-700">I understand that this
                                    action is irreversible</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300"
                            onclick="document.getElementById('deleteModal').classList.add('hidden')">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Delete Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Any javascript initialization here
        });
    </script>
</x-app-layout>