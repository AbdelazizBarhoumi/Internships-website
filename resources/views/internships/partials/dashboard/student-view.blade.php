<!-- Applicant Dashboard -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Total Applications</h3>
                    <p class="text-3xl font-bold text-indigo-600 mt-1">{{ auth()->user()->applications->count() }}</p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <a href="{{ route('applications.my.index') }}"
                class="flex items-center justify-between hover:text-indigo-600">
                <span>View all</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 text-amber-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Pending</h3>
                    <p class="text-3xl font-bold text-amber-500 mt-1">
                        {{ auth()->user()->applications()->where('status', 'pending')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <div class="flex items-center justify-between">
                <span>Awaiting review</span>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Interviewed</h3>
                    <p class="text-3xl font-bold text-blue-500 mt-1">
                        {{ auth()->user()->applications()->where('status', 'interviewed')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <div class="flex items-center justify-between">
                <span>Interview completed</span>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Accepted</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">
                        {{ auth()->user()->applications()->where('status', 'accepted')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="px-6 py-2 bg-gray-50 text-xs text-gray-600">
            <div class="flex items-center justify-between">
                <span>Congratulations!</span>
            </div>
        </div>
    </div>
</div>

<!-- Profile Completion -->
@php
    $user = auth()->user();
    $student = $user->student;
    $completionFields = [
        'hasResume' => !empty($student?->resume_path),
        'hasSkills' => !empty($student?->skills),
        'hasEducation' => !empty($student?->education_level) && !empty($student?->institution),
        'hasLinks' => !empty($student?->linkedin_url) || !empty($student?->github_url) || !empty($student?->portfolio_url),
        'hasBio' => !empty($student?->bio)
    ];
    $completedItems = array_filter($completionFields);
    $completionPercentage = count($completedItems) / count($completionFields) * 100;
@endphp

@if($completionPercentage < 100)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Profile Completion</h3>
                <span
                    class="text-sm font-medium {{ $completionPercentage < 50 ? 'text-red-600' : ($completionPercentage < 80 ? 'text-amber-600' : 'text-green-600') }}">
                    {{ round($completionPercentage) }}% Complete
                </span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="h-2.5 rounded-full {{ $completionPercentage < 50 ? 'bg-red-600' : ($completionPercentage < 80 ? 'bg-amber-500' : 'bg-green-600') }}"
                    style="width: {{ $completionPercentage }}%"></div>
            </div>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="flex items-center">
                    <div class="{{ $completionFields['hasResume'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                        @if($completionFields['hasResume'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <span class="text-sm {{ $completionFields['hasResume'] ? 'text-gray-700' : 'text-gray-500' }}">Upload
                        resume</span>
                </div>
                <div class="flex items-center">
                    <div class="{{ $completionFields['hasSkills'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                        @if($completionFields['hasSkills'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <span class="text-sm {{ $completionFields['hasSkills'] ? 'text-gray-700' : 'text-gray-500' }}">Add your
                        skills</span>
                </div>
                <div class="flex items-center">
                    <div class="{{ $completionFields['hasEducation'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                        @if($completionFields['hasEducation'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <span
                        class="text-sm {{ $completionFields['hasEducation'] ? 'text-gray-700' : 'text-gray-500' }}">Complete
                        education details</span>
                </div>
                <div class="flex items-center">
                    <div class="{{ $completionFields['hasLinks'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                        @if($completionFields['hasLinks'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <span class="text-sm {{ $completionFields['hasLinks'] ? 'text-gray-700' : 'text-gray-500' }}">Add
                        professional links</span>
                </div>
                <div class="flex items-center">
                    <div class="{{ $completionFields['hasBio'] ? 'text-green-500' : 'text-gray-400' }} mr-2">
                        @if($completionFields['hasBio'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <span class="text-sm {{ $completionFields['hasBio'] ? 'text-gray-700' : 'text-gray-500' }}">Write a
                        professional bio</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Complete your profile
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endif

<!-- Recent Applications -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="px-6 pt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
            <a href="{{ route('applications.my.index') }}"
                class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center">
                View all
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>

    @if(auth()->user()->applications->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Internship</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Company</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applied Date</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach(auth()->user()->applications->sortByDesc('created_at')->take(5) as $application)
                        <tr
                            class="hover:bg-gray-50 {{ !$application->internship->employer->user->is_active ? 'bg-gray-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($application->internship->employer->user->is_active)
                                    <a href="{{ route('internship.show', $application->internship) }}">
                                        <div class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                            {{ $application->internship->title }}</div>
                                    </a>
                                @else
                                    <div class="text-sm font-medium text-gray-500">{{ $application->internship->title }}</div>
                                    <div class="text-xs text-red-500">
                                        Employer account inactive
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($application->internship->employer->employer_logo)
                                        <img src="{{ Storage::url($application->internship->employer->employer_logo) }}"
                                            alt="{{ $application->internship->employer->employer_name }}"
                                            class="h-6 w-6 rounded-full mr-2 object-contain {{ !$application->internship->employer->user->is_active ? 'opacity-50' : '' }}">
                                    @endif
                                    <div
                                        class="text-sm {{ $application->internship->employer->user->is_active ? 'text-gray-500' : 'text-gray-400' }}">
                                        {{ $application->internship->employer->employer_name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('applications.show', $application) }}"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    View {{ !$application->internship->employer->user->is_active ? 'Details' : '' }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-gray-500 mb-4">You haven't applied for any internships yet.</p>
            <a href="{{ route('home') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Browse Internships
            </a>
        </div>
    @endif
</div>

<!-- Recommended Internships -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recommended For You</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                // Get featured internships from active employers only
                $featuredInternships = \App\Models\Internship::whereHas('employer.user', function ($query) {
                    $query->where('is_active', true);
                })
                    ->where('featured', true)
                    ->latest()
                    ->take(6)
                    ->get();
            @endphp

            @forelse($featuredInternships as $internship)
                <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow group">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                @if($internship->employer->employer_logo)
                                    <img src="{{ Storage::url($internship->employer->employer_logo) }}"
                                        alt="{{ $internship->employer->employer_name }}"
                                        class="h-10 w-10 rounded object-contain border p-1">
                                @else
                                    <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <h4
                                    class="font-medium text-gray-900 group-hover:text-indigo-600 transition-colors duration-150 mb-1">
                                    {{ $internship->title }}
                                </h4>
                                <p class="text-gray-500 text-sm">{{ $internship->employer->employer_name }}</p>
                                <p class="text-gray-500 text-sm flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $internship->location }}
                                </p>
                            </div>
                        </div>

                        @if($internship->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mt-3">
                                @foreach($internship->randomTags(2) as $tag)
                                    <x-tag :tag="$tag" size="small" />
                                @endforeach
                                @if($internship->tags->count() > 2)
                                    <span
                                        class="inline-flex items-center text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-800">
                                        +{{ $internship->tags->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div class="mt-3 pt-3 border-t flex items-center justify-between">
                            <span class="inline-flex items-center text-xs text-gray-500">
                                @if($internship->deadline_date)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $internship->deadline_date->diffForHumans() }}
                                @endif
                            </span>

                            <a href="{{ route('internship.show', $internship) }}"
                                class="inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-500">
                                View Details
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500">No featured internships available right now.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Browse all internships
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div>