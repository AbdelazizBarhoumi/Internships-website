<!-- filepath: c:\xampp\htdocs\internships-website\resources\views\internships\partials\dashboard\employer-view.blade.php -->
<!-- Employer Dashboard -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Active Internships</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $activeInternships ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <a href="{{ route('myInternships') }}" class="flex items-center justify-between hover:text-blue-600">
                <span>Manage internships</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Total Applicants</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $totalApplicants ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <a href="{{ route('applications.index') }}" class="flex items-center justify-between hover:text-purple-600">
                <span>View all applications</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 text-amber-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Pending Review</h3>
                    <p class="text-3xl font-bold text-amber-500 mt-1">
                        {{ $pendingApplications ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <div class="flex items-center justify-between">
                <span>Applications awaiting your review</span>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Accepted</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">
                        {{ $acceptedApplications ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <div class="flex items-center justify-between">
                <span>Applicants you've accepted</span>
            </div>
        </div>
    </div>
</div>

<!-- Profile Completion -->
@php
    $user = auth()->user();
    $employer = $user->employer;
    $completionFields = [
        'hasLogo' => !empty($employer?->employer_logo),
        'hasDescription' => !empty($employer?->description),
        'hasWebsite' => !empty($employer?->website),
        'hasIndustry' => !empty($employer?->industry),
        'hasPhone' => !empty($employer?->phone),
        'hasLocation' => !empty($employer?->location)
    ];
    $completedItems = array_filter($completionFields);
    $completionPercentage = count($completedItems) / count($completionFields) * 100;
@endphp

@if($completionPercentage < 100)
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Company Profile Completion</h3>
            <span class="text-sm font-medium {{ $completionPercentage < 50 ? 'text-red-600' : ($completionPercentage < 80 ? 'text-amber-600' : 'text-green-600') }}">
                {{ round($completionPercentage) }}% Complete
            </span>
        </div>
        
        <div class="w-full bg-gray-200 rounded-full h-2.5">

            <div class="h-2.5 rounded-full {{ $completionPercentage < 50 ? 'bg-red-600' : ($completionPercentage < 80 ? 'bg-amber-500' : 'bg-green-600') }}" 
                style="width: {{ $completionPercentage }}%"></div>
        </div>
        
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="flex items-center">
                <div class="{{ $completionFields['hasLogo'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                    @if($completionFields['hasLogo'])
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <span class="text-sm {{ $completionFields['hasLogo'] ? 'text-gray-700' : 'text-gray-500' }}">Upload company logo</span>
            </div>
            
            <div class="flex items-center">
                <div class="{{ $completionFields['hasDescription'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                    @if($completionFields['hasDescription'])
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <span class="text-sm {{ $completionFields['hasDescription'] ? 'text-gray-700' : 'text-gray-500' }}">Add company description</span>
            </div>
            
            <div class="flex items-center">
                <div class="{{ $completionFields['hasIndustry'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                    @if($completionFields['hasIndustry'])
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <span class="text-sm {{ $completionFields['hasIndustry'] ? 'text-gray-700' : 'text-gray-500' }}">Select industry</span>
            </div>
            
            <div class="flex items-center">
                <div class="{{ $completionFields['hasWebsite'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                    @if($completionFields['hasWebsite'])
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <span class="text-sm {{ $completionFields['hasWebsite'] ? 'text-gray-700' : 'text-gray-500' }}">Add company website</span>
            </div>
            
            <div class="flex items-center">
                <div class="{{ $completionFields['hasPhone'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                    @if($completionFields['hasPhone'])
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <span class="text-sm {{ $completionFields['hasPhone'] ? 'text-gray-700' : 'text-gray-500' }}">Add contact phone</span>
            </div>
            
            <div class="flex items-center">
                <div class="{{ $completionFields['hasLocation'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                    @if($completionFields['hasLocation'])
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <span class="text-sm {{ $completionFields['hasLocation'] ? 'text-gray-700' : 'text-gray-500' }}">Add company location</span>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                Complete your company profile
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</div>
@endif

<!-- Recent Applications Received -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="px-6 pt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent Applications Received</h3>
            <a href="{{ route('applications.index') }}" class="text-sm text-blue-600 hover:text-blue-500 flex items-center">
                View all
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
    @if(isset($recentApplications) && $recentApplications->count() > 0)
        <div class="overflow-x-auto">
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
                            Received Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentApplications as $application)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $application->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $application->internship->title }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($application->internship->location, 20) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $application->created_at->diffForHumans() }}</div>
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
                                    {{ $application->statusLabel ?? ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('applications.show', $application) }}" class="text-blue-600 hover:text-blue-900">Review</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-gray-500 mb-4">You haven't received any applications yet.</p>
            <a href="{{ route('internship.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Create a New Internship
            </a>
        </div>
    @endif
</div>

<!-- Your Active Internships -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="px-6 pt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Your Active Internships</h3>
            <a href="{{ route('internship.create') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs rounded-md font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Internship
            </a>
        </div>
    </div>

    @if(isset($activeInternshipsList) && $activeInternshipsList->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
            @foreach($activeInternshipsList as $internship)
                <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between border-b px-4 py-2 bg-gray-50">
                        <div class="flex items-center">
                            @if($internship->is_featured)
                                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full mr-2">Featured</span>
                            @endif
                            <h4 class="font-medium text-gray-900">{{ Str::limit($internship->title, 30) }}</h4>
                        </div>
                        <div class="text-xs text-gray-500">
                            @if($internship->deadline_date && $internship->deadline_date->isFuture())
                                {{ $internship->deadline_date->diffForHumans() }}
                            @elseif($internship->deadline_date)
                                <span class="text-red-600">Expired</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600">{{ $internship->location }}</span>
                            </div>
                            <span class="text-sm {{ $internship->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $internship->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-3">
                            <div class="inline-flex items-center text-sm text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $internship->applications_count ?? 0 }} Applicants
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ ucfirst($internship->type) }}
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mt-4 pt-3 border-t">
                            <a href="{{ route('myinternship.edit', $internship) }}" class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit
                            </a>
                            <a href="{{ route('internship.show', $internship) }}" class="text-gray-600 hover:text-gray-900 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                View
                            </a>
                            <div class="text-gray-600 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $internship->views ?? 0 }} Views
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="px-6 py-3 border-t bg-gray-50 flex justify-center">
            <a href="{{ route('myInternships') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                View all your internships
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    @else
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <p class="text-gray-500 mb-4">You haven't created any internships yet.</p>
            <a href="{{ route('internship.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Create Your First Internship
            </a>
        </div>
    @endif
</div>

<!-- Recent Hiring Activity -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Hiring Activity</h3>
        
        <div class="space-y-4">
            @if(isset($recentActivity) && $recentActivity->count() > 0)
                @foreach($recentActivity as $activity)
                    <div class="flex items-start">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium">{{ $activity->description }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                                <span class="mx-2 text-gray-400">•</span>
                                <span class="text-sm text-gray-500">{{ $activity->internship->title ?? 'Unknown internship' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-6">
                    <p class="text-gray-500">No recent activity to display.</p>
                </div>
            @endif
        </div>
        
        @if(isset($recentActivity) && $recentActivity->count() > 0)
            <div class="mt-6 text-center">
                <a href="{{ route('employer.activity') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View All Activity
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>