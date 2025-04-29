<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Application Details
            </h2>
            <a href="{{ route('admin.applications') }}" class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                &larr; Back to Applications
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        
            <!-- Application Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold">
                                {{ $application->user->name }}
                                <span class="text-gray-600">→</span>
                                {{ $application->internship->title }}
                            </h1>
                            
                            <p class="text-gray-600 mt-1">
                                <span class="font-medium">{{ $application->internship->employer->company_name }}</span>
                            </p>
                            
                            <div class="mt-2">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                                
                                <span class="text-gray-500 ml-2">
                                    Applied {{ $application->created_at->format('F j, Y') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.users.show', $application->user) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                View Applicant
                            </a>
                            
                            <a href="{{ route('admin.internships.show', $application->internship) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                View Internship
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Application Status Update -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Update Application Status</h3>
                    
                    <form action="{{ route('admin.applications.update-status', $application) }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                                    <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewing" {{ $application->status === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                    <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Admin Notes (Internal Only)</label>
                                <textarea name="admin_notes" id="admin_notes" rows="4" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">{{ $application->admin_notes }}</textarea>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Application Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Application Details</h3>
                    
                    <div class="prose max-w-none">
                        <h4 class="text-md font-medium">Cover Letter</h4>
                        <div class="bg-gray-50 p-4 rounded mb-6">
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                        
                        <h4 class="text-md font-medium">Resume/CV</h4>
                        <div class="mt-2">
                            @if($application->resume_path)
                                <a href="{{ asset('storage/' . $application->resume_path) }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded hover:bg-blue-200" target="_blank">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                                    </svg>
                                    Download Resume
                                </a>
                            @else
                                <span class="text-gray-500">No resume uploaded</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Applicant Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Applicant Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $application->user->name }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p>{{ $application->user->email }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p>{{ $application->user->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Total Applications</p>
                                <p>{{ $application->user->applications()->count() }}</p>
                            </div>
                            
                            <div>
                                <a href="{{ route('admin.users.show', $application->user) }}" class="text-blue-600 hover:underline">
                                    View Full Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>