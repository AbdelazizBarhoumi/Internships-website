<x-app-layout>
    <!-- Page Header -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $application->internship->title }}
            </h2>
            <div>
                <a href="{{ route('myinternship.show', $application->internship) }}"
                    class="text-indigo-600 hover:text-indigo-800">
                    View Internship Details
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Applicant Header -->
            <div class="sticky top-0 z-30 bg-white shadow-sm rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-semibold">
                            {{ $application->user->name }}
                        </h1>
                        <span class="px-3 py-1 text-sm font-medium rounded-full
                            @if($application->status == 'accepted') bg-green-100 text-green-800
                            @elseif($application->status == 'rejected') bg-red-100 text-red-800
                            @elseif($application->status == 'interviewed') bg-purple-100 text-purple-800
                            @elseif($application->status == 'reviewing') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">
                            Applied {{ $application->created_at->format('M j, Y') }}
                            ({{ $application->created_at->diffForHumans() }})
                        </span>
                    </div>
                </div>

                <div class="flex items-center flex-wrap gap-3 mt-6">
                    <div class="flex-grow flex gap-2">
                        <form method="POST" action="{{ route('applications.update-status', $application) }}"
                            class="flex">
                            @csrf
                            @method('PATCH')
                            <select name="status"
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Change Status</option>
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                <option value="interviewed" {{ $application->status == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accept</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                            </select>
                            <button type="submit"
                                class="ml-2 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Update Status
                            </button>
                        </form>
                    </div>
                    <div class="flex gap-2">
                        <a href="mailto:{{ $application->user->email }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email Applicant
                        </a>
                        <a href="{{ route('applications.index', ['internship_id' => $application->internship_id]) }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            All Applications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Two Column Layout with Fixed Left Column -->
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 min-h-[calc(100vh-8rem)]">
                <!-- Fixed Left Column: Applicant Information (2/6) -->
                <div class="col-span-2 md:sticky md:top-[5.5rem] md:self-start md:max-h-[calc(100vh-6rem)] md:overflow-y-auto">
                    <!-- Applicant Information Card -->
                    <div class="bg-white shadow-sm rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Applicant Information</h3>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $application->user->name }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">
                                    <a href="mailto:{{ $application->user->email }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $application->user->email }}
                                    </a>
                                </p>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Phone</p>
                                @if($application->phone)
                                    <p class="font-medium">
                                        <a href="tel:{{ $application->phone }}" class="text-indigo-600 hover:underline">
                                            {{ $application->phone }}
                                        </a>
                                    </p>
                                @else
                                    <p class="text-gray-500 italic">Not provided</p>
                                @endif
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Available to Start</p>
                                @if($application->availability)
                                    <p class="font-medium">{{ date('F j, Y', strtotime($application->availability)) }}</p>
                                @else
                                    <p class="text-gray-500 italic">Not specified</p>
                                @endif
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Education</p>
                                @if($application->education)
                                    <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $application->education)) }}</p>
                                @else
                                    <p class="text-gray-500 italic">Not specified</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Institution</p>
                                @if($application->institution)
                                    <p class="font-medium">{{ $application->institution }}</p>
                                @else
                                    <p class="text-gray-500 italic">Not specified</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Employer Notes Section -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Employer Notes</h3>
                            <form method="POST" action="{{ route('applications.update-notes', $application) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-4">
                                    <textarea name="notes" rows="4"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Add private notes about this applicant...">{{ $application->notes }}</textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-gray-800 text-white px-4 py-2 text-sm rounded-md hover:bg-gray-700">
                                        Save Notes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Application Details (4/6) - Scrollable content -->
                <div class="col-span-4">
                    <!-- Documents -->
                    <div class="bg-white shadow-sm rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Documents</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($application->resume_path)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500 mr-3"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                <div>
                                                    <p class="font-medium">Resume</p>
                                                    <p class="text-sm text-gray-500">PDF Document</p>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <a href="{{ Storage::url($application->resume_path) }}" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-900 px-2">View</a>
                                                <a href="{{ Storage::url($application->resume_path) }}" download
                                                    class="text-indigo-600 hover:text-indigo-900 px-2">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($application->transcript_path)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-3"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <div>
                                                    <p class="font-medium">Transcript</p>
                                                    <p class="text-sm text-gray-500">PDF Document</p>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <a href="{{ Storage::url($application->transcript_path) }}" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-900 px-2">View</a>
                                                <a href="{{ Storage::url($application->transcript_path) }}" download
                                                    class="text-indigo-600 hover:text-indigo-900 px-2">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(!$application->resume_path && !$application->transcript_path)
                                    <div class="col-span-2 text-center py-4 text-gray-500">
                                        No documents uploaded with this application
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Rest of your content remains the same -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>