<x-app-layout>
    <!-- Page Header -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $application->internship->title }}
            </h2>
            <div>
            @if(auth()->user()->isEmployer())
                <a href="{{ route('myinternship.show', $application->internship) }}"
                    class="text-indigo-600 hover:text-indigo-800">
                    View Internship Details
                </a>
            @else
                <a href="{{ route('internship.show', $application->internship) }}"
                    class="text-indigo-600 hover:text-indigo-800">
                    View Internship Details
                </a>
            @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Applicant Header -->
            @if(auth()->user()->isEmployer())
            <div class="sticky top-0 z-30 bg-white shadow-sm rounded-lg p-4">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                    <div class="flex items-center space-x-4 mb-3 lg:mb-0">
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
                    <div class="mb-4 lg:mb-0">
                        <span class="text-gray-500 text-sm">
                            Applied {{ $application->created_at->format('M j, Y') }}
                            ({{ $application->created_at->diffForHumans() }})
                        </span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mt-4">
                    <div class="flex-grow w-full sm:w-auto">
                        <form method="POST" action="{{ route('applications.update-status', $application) }}"
                            class="flex flex-col sm:flex-row gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status"
                                class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Change Status</option>
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>
                                    Reviewing</option>
                                <option value="interviewed" {{ $application->status == 'interviewed' ? 'selected' : '' }}>
                                    Interviewed</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accept
                                </option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Reject
                                </option>
                            </select>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Update Status
                            </button>
                        </form>
                    </div>
                    <div class="flex flex-wrap gap-2">
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
            @else
            <div class="sticky top-0 z-30 bg-white shadow-sm rounded-lg p-4">
                <h1 class="text-xl font-semibold mb-4">
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


            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Left Column: Applicant Info -->
                <div class="lg:col-span-1 lg:sticky "
                    style="top: 6rem; max-height: calc(100vh - 8rem); overflow-y: auto;">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 ">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Applicant Information</h3>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $application->user->name }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $application->user->email }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium">{{ $application->phone ?? 'Not provided' }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Available to Start</p>
                                <p class="font-medium">
                                    {{ $application->availability ? date('F j, Y', strtotime($application->availability)) : 'Not specified' }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Education</p>
                                <p class="font-medium">
                                    {{ ucfirst(str_replace('_', ' ', $application->education)) ?? 'Not specified' }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Institution</p>
                                <p class="font-medium">{{ $application->institution ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->isEmployer())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Employer Notes</h3>

                            <form method="POST" action="{{ route('applications.update-notes', $application) }}">
                                @csrf
                                @method('PATCH')

                                <div class="mb-4">
                                    <textarea name="notes" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Add private notes about this applicant...">{{ $application->notes }}</textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                        Save Notes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    
                </div>

                <!-- Right Column: Application Details -->
                <div class="lg:col-span-2">
                    <!-- Documents -->
                    <!-- Replace your current document links with these -->

                    <!-- Documents -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Documents</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($application->resume_path)
                                    <a href="{{ route('applications.download', ['application' => $application, 'type' => 'resume']) }}"
                                        class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
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
                                            <div class="flex space-x-3">
                                                <span class="text-indigo-600 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endif

                                @if($application->transcript_path)
                                    <a href="{{ route('applications.download', ['application' => $application, 'type' => 'transcript']) }}"
                                        class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
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
                                            <div class="flex space-x-3">
                                                <span class="text-indigo-600 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endif

                                @if(!$application->resume_path && !$application->transcript_path)
                                    <div class="col-span-2 text-center py-8 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-3"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        <p>No documents were uploaded with this application</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Skills</h3>

                            @if($application->skills)
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $application->skills) as $skill)
                                        <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">
                                            {{ trim($skill) }}
                                            ass </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No skills listed</p>
                            @endif
                        </div>
                    </div>

                    <!-- Cover Letter -->
                    @if($application->cover_letter)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 min-h-64">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Cover Letter</h3>
                                <div class="prose max-w-none border-l-4 border-gray-200 pl-4">
                                    {!! nl2br(e($application->cover_letter)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Why Interested -->
                    @if($application->why_interested)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 min-h-64">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Why Interested</h3>
                                <div class="prose max-w-none border-l-4 border-gray-200 pl-4">
                                    {!! nl2br(e($application->why_interested)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>