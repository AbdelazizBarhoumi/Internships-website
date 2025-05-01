<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Apply for {{ $internship->title }}
            </h2>
            <div class="flex gap-2">
                <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    {{ $internship->type }}
                </span>
                @if($internship->deadline_date)
                    <span class="text-sm {{ \Carbon\Carbon::parse($internship->deadline_date)->isPast() ? 'bg-red-100 text-red-800' : (\Carbon\Carbon::parse($internship->deadline_date)->diffInDays(now()) < 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-amber-100 text-amber-800') }} px-3 py-1 rounded-full">
                        Deadline: {{ \Carbon\Carbon::parse($internship->deadline_date)->format('M j, Y') }}
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Sticky application progress bar -->
            <div class="sticky top-0 z-10 bg-white shadow-md rounded-lg p-4 mb-6 transition-all duration-300" id="progress-container">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-medium text-gray-900">Application Progress</h3>
                    <span class="text-sm font-medium text-blue-600" id="progress-percentage">0%</span>
                </div>
                <div class="relative">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                        <div id="progress-bar" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <div class="flex justify-between text-xs font-medium">
                        <span class="progress-step-text text-blue-700">Start</span>
                        <span class="progress-step-text text-gray-500">Personal</span>
                        <span class="progress-step-text text-gray-500">Education</span>
                        <span class="progress-step-text text-gray-500">Documents</span>
                        <span class="progress-step-text text-gray-500">Submit</span>
                    </div>
                </div>
            </div>

            <!-- Internship Summary Card with Accordion -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div x-data="{expanded: false}" class="border-b border-gray-200">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($internship->employer->logo_path)
                                    <img src="{{ Storage::url($internship->employer->logo_path) }}" alt="{{ $internship->employer->company_name }} logo" class="h-16 w-16 object-contain mr-4 rounded shadow-sm">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 flex items-center justify-center text-gray-500 mr-4 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-lg font-bold text-gray-900">{{ $internship->title }}</h3>
                                <p class="text-gray-600">{{ $internship->employer->company_name }} · {{ $internship->location }}</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @if($internship->compensation_type)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            {{ $internship->compensation_type }}
                                        </span>
                                    @endif
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">
                                        {{ $internship->duration ?? 'Duration not specified' }}
                                    </span>
                                </div>
                            </div>
                            <button @click="expanded = !expanded" class="ml-auto flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 focus:outline-none">
                                <span x-text="expanded ? 'Hide details' : 'Show details'">Show details</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transition-transform duration-200" :class="{'rotate-180': expanded}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Expandable details section -->
                    <div x-show="expanded" x-collapse x-cloak class="p-6 pt-0 border-t border-gray-100 bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">About this internship</h4>
                                <p class="text-sm text-gray-600">{{ $internship->description ?? 'No description provided' }}</p>
                                
                                <h4 class="text-sm font-medium text-gray-700 mt-4 mb-2">Required Skills</h4>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $skillsArray = explode(',', $internship->required_skills ?? '');
                                    @endphp
                                    @forelse($skillsArray as $skill)
                                        @if(trim($skill))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ trim($skill) }}
                                            </span>
                                        @endif
                                    @empty
                                        <span class="text-sm text-gray-500">No specific skills listed</span>
                                    @endforelse
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Details</h4>
                                <dl class="divide-y divide-gray-100">
                                    <div class="grid grid-cols-3 py-2">
                                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                                        <dd class="text-sm text-gray-900 col-span-2">{{ $internship->location }}</dd>
                                    </div>
                                    <div class="grid grid-cols-3 py-2">
                                        <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                                        <dd class="text-sm text-gray-900 col-span-2">{{ $internship->start_date ? \Carbon\Carbon::parse($internship->start_date)->format('M j, Y') : 'Flexible' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-3 py-2">
                                        <dt class="text-sm font-medium text-gray-500">Work Format</dt>
                                        <dd class="text-sm text-gray-900 col-span-2">{{ $internship->work_format ?? 'Not specified' }}</dd>
                                    </div>
                                    <div class="grid grid-cols-3 py-2">
                                        <dt class="text-sm font-medium text-gray-500">About Company</dt>
                                        <dd class="text-sm text-gray-900 col-span-2">
                                            {{ Str::limit($internship->employer->description, 100) ?? 'No company description available' }}
                                            <a href="{{ route('home', $internship->employer) }}" class="text-blue-600 hover:text-blue-800">Learn more</a>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
                            <p class="font-bold">Information</p>
                            <p>{{ session('info') }}</p>
                        </div>
                    @endif

                    <form id="application-form" method="POST" action="{{ route('applications.store', $internship) }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Application sections with improved styling -->
                        <!-- Personal Information -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm section-container hover:border-blue-300 transition-colors">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2 step-indicator">1</span>
                                Personal Information
                                <span class="ml-auto text-xs text-blue-600 section-status" id="section-1-status">Not started</span>
                            </h3>
                            
                            <!-- Information from Student Profile -->
                            @if(isset($student))
                            <div class="p-4 mb-6 bg-blue-50 rounded-lg">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-blue-800">The following information has been pre-filled from your profile</span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Education Level:</span>
                                        <span class="ml-2 font-medium">{{ ucfirst(str_replace('_', ' ', $student->education_level)) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Institution:</span>
                                        <span class="ml-2 font-medium">{{ $student->institution }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Field of Study:</span>
                                        <span class="ml-2 font-medium">{{ $student->field_of_study ?? 'Not specified' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Expected Graduation:</span>
                                        <span class="ml-2 font-medium">{{ $student->graduation_date ? \Carbon\Carbon::parse($student->graduation_date)->format('M Y') : 'Not specified' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="ml-2 font-medium">{{ $student->phone ?? 'Not specified' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Portfolio:</span>
                                        <span class="ml-2 font-medium">
                                            @if($student->portfolio_url)
                                                <a href="{{ $student->portfolio_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                                    View Portfolio
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            @else
                                                Not specified
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <p class="mt-3 text-xs text-blue-700">
                                    Need to update your information? <a href="{{ route('profile.edit') }}" class="underline font-medium">Edit your profile</a> first, then return to complete your application.
                                </p>
                            </div>
                            @endif
                            <!-- Student Photo Display -->
@if($student && $student->profile_photo_path)
<div class="mt-4 flex items-center">
    <div class="flex-shrink-0">
        <img src="{{ Storage::url($student->profile_photo_path) }}" alt="Profile Photo" 
             class="h-20 w-20 rounded-full object-cover border-2 border-blue-300">
    </div>
    <div class="ml-4">
        <p class="text-sm text-gray-600">Your profile photo will be included with your application</p>
        <a href="{{ route('profile.edit') }}" class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
            Update photo
        </a>
    </div>
</div>
@endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number*</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <input type="tel" name="phone" id="phone" class="mt-1 block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('phone', $student->phone ?? '') }}" required>
                                    </div>
                                    @error('phone')
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        Your phone number will be used if the employer needs to contact you directly.
                                    </p>
                                </div>
                                
                                <div>
                                    <label for="availability" class="block text-sm font-medium text-gray-700">Available Start Date*</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date" name="availability" id="availability" class="mt-1 block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('availability') }}" required>
                                    </div>
                                    @error('availability')
                                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        When could you start working if selected for this internship?
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Documents Section with visual improvements -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm section-container hover:border-blue-300 transition-colors">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2 step-indicator">2</span>
                                Documents
                                <span class="ml-auto text-xs text-blue-600 section-status" id="section-2-status">Not started</span>
                            </h3>
                            
                            <div class="mb-6">
                                <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">Resume (PDF)*</label>
                                
                                @if($student && $student->resume_path)
                                    <div class="flex items-center mb-3 p-3 bg-gray-50 rounded-md border border-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div class="ml-2">
                                            <span class="block text-sm text-gray-700">
                                                Using existing resume from your profile
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                Uploaded {{ \Carbon\Carbon::parse($student->updated_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                        <div class="ml-auto flex">
                                            <a href="{{ Storage::url($student->resume_path) }}" target="_blank" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 hover:text-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Preview
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-700 mb-2">
                                        <div class="flex items-center">
                                            <input id="use_existing_resume" name="use_existing_resume" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                            <label for="use_existing_resume" class="ml-2 block text-gray-700">
                                                Use this resume
                                            </label>
                                        </div>
                                        <div class="mt-2" id="upload_new_resume_container">
                                            <label for="resume" class="block text-sm font-medium text-gray-700">Upload new resume:</label>
                                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                                                <div class="space-y-1 text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label for="resume" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                            <span>Upload a file</span>
                                                            <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf">
                                                        </label>
                                                        <p class="pl-1">or drag and drop</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">PDF up to 5MB</p>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm hidden" id="resume-file-name"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="resume" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF up to 5MB</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm hidden" id="resume-file-name"></div>
                                @endif
                                
                                @error('resume')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                                
                                <p class="mt-1 text-xs text-gray-500">
                                    Upload a PDF document that highlights your education, skills, and any relevant experience.
                                </p>
                            </div>

                            <div class="mb-6">
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover Letter</label>
                                <textarea name="cover_letter" id="cover_letter" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Introduce yourself and explain why you're a good fit for this position...">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    A good cover letter should address why you're interested in this specific internship and how your skills match what they're looking for.
                                </p>
                                
                                <!-- Cover letter tips accordion -->
                                <div x-data="{ open: false }" class="mt-3">
                                    <button type="button" @click="open = !open" class="flex items-center text-xs text-blue-600 hover:text-blue-800 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-90': open}" class="h-4 w-4 mr-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Tips for writing an effective cover letter
                                    </button>
                                    <div x-show="open" x-collapse class="mt-2 p-3 bg-blue-50 text-xs text-gray-700 rounded">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Address your letter to a specific person if possible</li>
                                            <li>Explain why you're interested in this specific position and company</li>
                                            <li>Highlight relevant skills and experiences that match the job description</li>
                                            <li>Keep it concise - aim for 250-400 words</li>
                                            <li>End with a clear call to action</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="transcript" class="block text-sm font-medium text-gray-700">Academic Transcript (Optional)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="transcript" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="transcript" name="transcript" type="file" class="sr-only" accept=".pdf">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF up to 5MB</p>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm hidden" id="transcript-file-name"></div>
                                @error('transcript')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    If relevant to the position, you can upload your academic transcript as a PDF.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Skills & Experience with matching pattern -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm section-container hover:border-blue-300 transition-colors">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2 step-indicator">3</span>
                                Skills & Experience
                                <span class="ml-auto text-xs text-blue-600 section-status" id="section-3-status">Not started</span>
                            </h3>
                            
                            <div class="mb-4">
                                <label for="skills" class="block text-sm font-medium text-gray-700">Relevant Skills*</label>
                                <div class="mt-1">
                                    <textarea name="skills" id="skills" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="List your relevant skills, separated by commas (e.g., Python, Data Analysis, Project Management)" required>{{ old('skills', $student->skills ?? '') }}</textarea>
                                </div>
                                @error('skills')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Focus on skills that match what the employer is looking for:
                                    </p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @php
                                            $skillsArray = explode(',', $internship->required_skills ?? '');
                                        @endphp
                                        @foreach($skillsArray as $skill)
                                            @if(trim($skill))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ trim($skill) }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            @if($student && $student->bio)
                            <div class="mt-4 p-3 bg-gray-50 rounded-md">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Your Bio</label>
                                <p class="text-sm text-gray-800 italic">{{ $student->bio }}</p>
                                <div class="mt-2 text-xs text-gray-500">
                                    This bio from your profile provides additional context about your background.
                                </div>
                            </div>
                            @endif
                            
                        </div>

                        <!-- Why You're Interested -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm section-container hover:border-blue-300 transition-colors">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2 step-indicator">4</span>
                                Why You're Interested
                                <span class="ml-auto text-xs text-blue-600 section-status" id="section-4-status">Not started</span>
                            </h3>
                            
                            <div>
                                <label for="why_interested" class="block text-sm font-medium text-gray-700">Why are you interested in this internship?*</label>
                                <textarea name="why_interested" id="why_interested" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Explain why you're interested in this specific role and what you hope to gain from the experience..." required>{{ old('why_interested') }}</textarea>
                                @error('why_interested')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                                
                                <!-- Word count indicator -->
                                <div class="mt-1 flex justify-between text-xs text-gray-500">
                                    <span>Be specific about why you're interested in {{ $internship->employer->company_name }}</span>
                                    <span id="word-count">0 words (aim for 100-200)</span>
                                </div>
                                
                                <!-- Writing quality indicator -->
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-700">Writing Quality</h4>
                                    <div class="mt-2 grid grid-cols-3 gap-2">
                                        <div class="p-2 bg-gray-50 rounded text-center">
                                            <span class="block text-xs font-medium text-gray-700">Clarity</span>
                                            <div class="mt-1 flex justify-center">
                                                <span id="clarity-score" class="inline-block h-2 w-2 rounded-full bg-gray-300"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                            </div>
                                        </div>
                                        <div class="p-2 bg-gray-50 rounded text-center">
                                            <span class="block text-xs font-medium text-gray-700">Relevance</span>
                                            <div class="mt-1 flex justify-center">
                                                <span id="relevance-score" class="inline-block h-2 w-2 rounded-full bg-gray-300"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                            </div>
                                        </div>
                                        <div class="p-2 bg-gray-50 rounded text-center">
                                            <span class="block text-xs font-medium text-gray-700">Specificity</span>
                                            <div class="mt-1 flex justify-center">
                                                <span id="specificity-score" class="inline-block h-2 w-2 rounded-full bg-gray-300"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                                <span class="inline-block h-2 w-2 rounded-full bg-gray-300 ml-1"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review and Submit -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm section-container hover:border-blue-300 transition-colors">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center mr-2 step-indicator">5</span>
                                Review & Submit
                            </h3>
                            
                            <div class="bg-gray-50 p-4 rounded-md mb-4">
                                <div class="flex items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <h4 class="ml-2 text-sm font-medium text-gray-900">Application Checklist</h4>
                                </div>
                                <ul class="text-sm text-gray-600 space-y-2 border-t border-gray-200 pt-2">
                                    <li class="flex items-center" id="phone-checkbox">
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full border border-gray-200 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        Phone number provided
                                    </li>
                                    <li class="flex items-center" id="availability-checkbox">
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full border border-gray-200 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        Available start date selected
                                    </li>
                                    <li class="flex items-center" id="resume-checkbox">
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full border border-gray-200 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        Resume uploaded
                                    </li>
                                    <li class="flex items-center" id="skills-checkbox">
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full border border-gray-200 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        Skills listed
                                    </li>
                                    <li class="flex items-center" id="why-interested-checkbox">
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full border border-gray-200 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        Interest statement written
                                    </li>
                                </ul>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between items-center">
                                <div class="mb-4 sm:mb-0">
                                    <h3 class="text-lg font-medium text-gray-900">Ready to submit?</h3>
                                    <p class="text-sm text-gray-600">
                                        Make sure all required fields are completed correctly.
                                    </p>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                                    <a href="{{ route('internship.show', $internship) }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                        </svg>
                                        Back to Internship
                                    </a>
                                    
                                    <button type="submit" id="submit-button" class="inline-flex justify-center items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 relative">
                                        <span>Submit Application</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 -mr-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                        </svg>
                                        
                                        <!-- Loading spinner (hidden by default) -->
                                        <span id="loading-spinner" class="absolute inset-0 flex items-center justify-center bg-blue-600 rounded-md hidden">
                                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        #upload_new_resume_container {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
            display: none;
        }
        
        .section-container {
            transition: all 0.3s ease;
        }
        
        .section-container:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Fancy file upload style */
        .file-upload-indicator {
            display: none;
        }
        
        /* Add shrink effect to sticky header */
        #progress-container.scrolled {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        /* Drop target styles */
        .drop-target {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.05);
        }
        
        /* Add highlighting to incomplete fields */
        .highlight-required:invalid {
            border-color: #ef4444;
        }
    </style>
    
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('application-form');
    const progressBar = document.getElementById('progress-bar');
    const progressPercentage = document.getElementById('progress-percentage');
    const progressContainer = document.getElementById('progress-container');
    const stepTexts = document.querySelectorAll('.progress-step-text');
    const sectionStatuses = document.querySelectorAll('.section-status');
    const requiredFields = form.querySelectorAll('[required]');
    const submitButton = document.getElementById('submit-button');
    const loadingSpinner = document.getElementById('loading-spinner');
    const wordCountElem = document.getElementById('word-count');
    const whyInterestedField = document.getElementById('why_interested');
    const skillsField = document.getElementById('skills');
    const skillMatchPercentage = document.getElementById('skill-match-percentage');
    const skillMatchBar = document.getElementById('skill-match-bar');
    
    // File upload elements
    const resumeInput = document.getElementById('resume');
    const transcriptInput = document.getElementById('transcript');
    const resumeFileName = document.getElementById('resume-file-name');
    const transcriptFileName = document.getElementById('transcript-file-name');
    
    // Checklist items
    const phoneCheckbox = document.getElementById('phone-checkbox').querySelector('svg');
    const availabilityCheckbox = document.getElementById('availability-checkbox').querySelector('svg');
    const resumeCheckbox = document.getElementById('resume-checkbox').querySelector('svg');
    const skillsCheckbox = document.getElementById('skills-checkbox').querySelector('svg');
    const whyInterestedCheckbox = document.getElementById('why-interested-checkbox').querySelector('svg');
    
    // Writing quality indicators
    const clarityScore = document.getElementById('clarity-score')?.parentNode.querySelectorAll('span');
    const relevanceScore = document.getElementById('relevance-score')?.parentNode.querySelectorAll('span');
    const specificityScore = document.getElementById('specificity-score')?.parentNode.querySelectorAll('span');
    
    // Handle resume toggle
    const useExistingResumeCheckbox = document.getElementById('use_existing_resume');
    const uploadNewResumeContainer = document.getElementById('upload_new_resume_container');
    
    if (useExistingResumeCheckbox && uploadNewResumeContainer) {
        // Initial state
        handleResumeToggle(useExistingResumeCheckbox.checked);
        
        // Toggle event
        useExistingResumeCheckbox.addEventListener('change', function() {
            handleResumeToggle(this.checked);
        });
    }
    
    function handleResumeToggle(useExisting) {
        if (useExisting) {
            uploadNewResumeContainer.style.display = 'none';
            if (resumeInput) {
                resumeInput.disabled = true;
                resumeInput.removeAttribute('required');
            }
        } else {
            uploadNewResumeContainer.style.display = 'block';
            // Force reflow to enable transition
            void uploadNewResumeContainer.offsetWidth;
            uploadNewResumeContainer.style.maxHeight = '200px';
            uploadNewResumeContainer.style.opacity = '1';
            
            if (resumeInput) {
                resumeInput.disabled = false;
                resumeInput.setAttribute('required', 'required');
            }
        }
        
        // Update progress bar after toggling
        setTimeout(updateProgress, 100);
    }
    
    // Set default availability date if not already set
    const availabilityInput = document.getElementById('availability');
    if (availabilityInput && !availabilityInput.value) {
        const twoWeeksFromNow = new Date();
        twoWeeksFromNow.setDate(twoWeeksFromNow.getDate() + 14);
        
        const year = twoWeeksFromNow.getFullYear();
        const month = String(twoWeeksFromNow.getMonth() + 1).padStart(2, '0');
        const day = String(twoWeeksFromNow.getDate()).padStart(2, '0');
        
        availabilityInput.value = `${year}-${month}-${day}`;
        updateProgress(); // Update progress after setting default date
    }
    
    // Update progress when fields change
    requiredFields.forEach(field => {
        if (field.tagName === 'TEXTAREA' || ['text', 'tel', 'email', 'date'].includes(field.type)) {
            field.addEventListener('input', updateProgress);
        }
        field.addEventListener('change', updateProgress);
    });
    
    // Handle file uploads
    if (resumeInput) {
        resumeInput.addEventListener('change', function(e) {
            handleFileSelection(e, resumeFileName);
            updateProgress();
        });
    }
    
    if (transcriptInput) {
        transcriptInput.addEventListener('change', function(e) {
            handleFileSelection(e, transcriptFileName);
        });
    }
    
    function handleFileSelection(e, fileNameElem) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2); // Convert to MB
            fileNameElem.textContent = `Selected: ${fileName} (${fileSize} MB)`;
            fileNameElem.classList.remove('hidden');
            fileNameElem.classList.add('text-blue-600');
        } else {
            fileNameElem.classList.add('hidden');
        }
    }
    
    // Handle drag and drop for file uploads
    const dropTargets = document.querySelectorAll('.border-dashed');
    dropTargets.forEach(target => {
        ['dragenter', 'dragover'].forEach(eventName => {
            target.addEventListener(eventName, e => {
                e.preventDefault();
                target.classList.add('drop-target');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            target.addEventListener(eventName, e => {
                e.preventDefault();
                target.classList.remove('drop-target');
            }, false);
        });
        
        target.addEventListener('drop', e => {
            const input = target.querySelector('input[type="file"]');
            if (input && e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        }, false);
    });
    
    // Handle word count for "why_interested" textarea
    if (whyInterestedField) {
        whyInterestedField.addEventListener('input', countWords);
        whyInterestedField.addEventListener('input', updateWritingQuality);
    }
    
    function countWords() {
        const text = whyInterestedField.value.trim();
        const words = text ? text.split(/\s+/).length : 0;
        
        // Update word count display
        wordCountElem.textContent = `${words} words (aim for 100-200)`;
        
        // Apply styling based on word count
        if (words < 50) {
            wordCountElem.className = 'text-xs text-red-500';
        } else if (words >= 50 && words < 100) {
            wordCountElem.className = 'text-xs text-yellow-500';
        } else if (words >= 100 && words <= 200) {
            wordCountElem.className = 'text-xs text-green-500';
        } else {
            wordCountElem.className = 'text-xs text-yellow-500';
        }
    }
    
    // Handle skill matching
    if (skillsField) {
        skillsField.addEventListener('input', updateSkillMatch);
    }
    
    function updateSkillMatch() {
        // Get required skills from the internship
        const requiredSkillsStr = "{{ $internship->required_skills ?? '' }}";
        const requiredSkills = requiredSkillsStr.split(',')
            .map(skill => skill.trim().toLowerCase())
            .filter(skill => skill.length > 0);
        
        // Get applicant skills
        const applicantSkills = skillsField.value.split(',')
            .map(skill => skill.trim().toLowerCase())
            .filter(skill => skill.length > 0);
        
        // Calculate match percentage
        let matchCount = 0;
        if (requiredSkills.length > 0) {
            for (const skill of applicantSkills) {
                if (requiredSkills.some(reqSkill => skill.includes(reqSkill) || reqSkill.includes(skill))) {
                    matchCount++;
                }
            }
            
            // Calculate percentage, cap at 100%
            const matchPercentage = Math.min(100, Math.round((matchCount / requiredSkills.length) * 100));
            
            if (skillMatchPercentage && skillMatchBar) {
                // Update UI
                skillMatchPercentage.textContent = matchPercentage + '%';
                skillMatchBar.style.width = matchPercentage + '%';
                
                // Update bar color based on match percentage
                if (matchPercentage < 30) {
                    skillMatchBar.classList.remove('bg-blue-600', 'bg-yellow-500', 'bg-green-500');
                    skillMatchBar.classList.add('bg-red-500');
                } else if (matchPercentage < 70) {
                    skillMatchBar.classList.remove('bg-blue-600', 'bg-red-500', 'bg-green-500');
                    skillMatchBar.classList.add('bg-yellow-500');
                } else {
                    skillMatchBar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-blue-600');
                    skillMatchBar.classList.add('bg-green-500');
                }
            }
        }
    }

    // Implement writing quality assessment
    function updateWritingQuality() {
        const text = whyInterestedField.value.trim();
        
        if (!text) {
            resetWritingQualityIndicators();
            return;
        }
        
        // Get words and calculate metrics
        const words = text.split(/\s+/);
        const wordCount = words.length;
        
        // Simple clarity score - based on average word length (shorter is clearer)
        const avgWordLength = words.join('').length / wordCount;
        const clarityValue = Math.min(5, Math.max(1, Math.round(6 - avgWordLength / 2)));
        
        // Simple relevance score - check for keywords related to internships
        const relevanceKeywords = ['internship', 'learn', 'experience', 'skill', 'career', 'opportunity', 'industry', 'professional', 'growth', 'interest', 'passion'];
        const relevanceHits = relevanceKeywords.filter(keyword => 
            text.toLowerCase().includes(keyword)
        ).length;
        const relevanceValue = Math.min(5, Math.max(1, Math.round(relevanceHits / 2)));
        
        // Simple specificity score - look for specific phrases and longer sentences
        const hasSpecificPhrases = text.includes('because') || text.includes('specifically') || text.includes('particularly');
        const sentenceCount = text.split(/[.!?]+/).filter(s => s.trim().length > 0).length;
        const avgSentenceLength = wordCount / sentenceCount;
        const specificityValue = Math.min(5, Math.max(1, Math.round((hasSpecificPhrases ? 2 : 0) + avgSentenceLength / 5)));
        
        // Update UI
        updateWritingScoreUI(clarityScore, clarityValue);
        updateWritingScoreUI(relevanceScore, relevanceValue);
        updateWritingScoreUI(specificityScore, specificityValue);
    }

    function resetWritingQualityIndicators() {
        // Reset all writing quality indicators to gray
        [clarityScore, relevanceScore, specificityScore].forEach(scoreSet => {
            if (scoreSet) {
                Array.from(scoreSet).forEach(dot => {
                    dot.classList.remove('bg-red-400', 'bg-yellow-400', 'bg-green-400');
                    dot.classList.add('bg-gray-300');
                });
            }
        });
    }

    function updateWritingScoreUI(scoreElements, value) {
        if (!scoreElements) return;
        
        // Reset all dots to gray
        Array.from(scoreElements).forEach(dot => {
            dot.classList.remove('bg-red-400', 'bg-yellow-400', 'bg-green-400');
            dot.classList.add('bg-gray-300');
        });
        
        // Determine color based on score
        let colorClass = 'bg-gray-300';
        if (value <= 2) {
            colorClass = 'bg-red-400';
        } else if (value <= 3) {
            colorClass = 'bg-yellow-400';
        } else {
            colorClass = 'bg-green-400';
        }
        
        // Fill in dots based on score value
        for (let i = 0; i < value; i++) {
            if (scoreElements[i]) {
                scoreElements[i].classList.remove('bg-gray-300');
                scoreElements[i].classList.add(colorClass);
            }
        }
    }

    // Update progress bar and section statuses - FIXED VERSION
    function updateProgress() {
        // Count required fields and completed required fields
        let totalRequired = 0;
        let completedFields = 0;
        let completedBySection = [0, 0, 0, 0]; // Track completion for each section
        const totalBySection = [0, 0, 0, 0]; // Total required fields by section
        
        // Section 1: Personal Information
        const phoneField = document.getElementById('phone');
        const availabilityField = document.getElementById('availability');
        
        // Phone field
        if (phoneField) {
            totalRequired++;
            totalBySection[0]++;
            if (phoneField.value.trim()) {
                completedFields++;
                completedBySection[0]++;
                phoneCheckbox.classList.remove('hidden');
            } else {
                phoneCheckbox.classList.add('hidden');
            }
        }
        
        // Availability field
        if (availabilityField) {
            totalRequired++;
            totalBySection[0]++;
            if (availabilityField.value) {
                completedFields++;
                completedBySection[0]++;
                availabilityCheckbox.classList.remove('hidden');
            } else {
                availabilityCheckbox.classList.add('hidden');
            }
        }
        
        // Section 2: Documents - Resume
        totalRequired++; // Resume is always required
        totalBySection[1]++;
        
        // Check if using existing resume or uploaded a new one
        if ((useExistingResumeCheckbox && useExistingResumeCheckbox.checked) || 
            (resumeInput && !resumeInput.disabled && resumeInput.files && resumeInput.files.length > 0)) {
            completedFields++;
            completedBySection[1]++;
            resumeCheckbox.classList.remove('hidden');
        } else {
            resumeCheckbox.classList.add('hidden');
        }
        
        // Section 3: Skills
        if (skillsField) {
            totalRequired++;
            totalBySection[2]++;
            if (skillsField.value.trim()) {
                completedFields++;
                completedBySection[2]++;
                skillsCheckbox.classList.remove('hidden');
            } else {
                skillsCheckbox.classList.add('hidden');
            }
        }
        
        // Section 4: Why interested
        if (whyInterestedField) {
            totalRequired++;
            totalBySection[3]++;
            if (whyInterestedField.value.trim()) {
                completedFields++;
                completedBySection[3]++;
                whyInterestedCheckbox.classList.remove('hidden');
            } else {
                whyInterestedCheckbox.classList.add('hidden');
            }
        }
        
        // Calculate progress - ensure it never exceeds 100%
        const progressValue = totalRequired > 0 ? Math.min(100, Math.round((completedFields / totalRequired) * 100)) : 0;
        progressBar.style.width = progressValue + '%';
        progressPercentage.textContent = progressValue + '%';
        
        // Update section statuses
        for (let i = 0; i < sectionStatuses.length; i++) {
            if (totalBySection[i] === 0) continue;
            
            const completionRatio = completedBySection[i] / totalBySection[i];
            
            if (completionRatio === 0) {
                sectionStatuses[i].textContent = 'Not started';
                sectionStatuses[i].className = 'ml-auto text-xs text-gray-500 section-status';
            } else if (completionRatio < 1) {
                sectionStatuses[i].textContent = 'In progress';
                sectionStatuses[i].className = 'ml-auto text-xs text-yellow-600 section-status';
            } else {
                sectionStatuses[i].textContent = 'Complete';
                sectionStatuses[i].className = 'ml-auto text-xs text-green-600 section-status';
            }
        }
        
        // Update progress steps
        stepTexts.forEach((step, index) => {
            const progressThresholds = [0, 25, 50, 75, 100];
            if (progressValue >= progressThresholds[index]) {
                step.classList.remove('text-gray-500');
                step.classList.add('text-blue-700', 'font-medium');
            } else {
                step.classList.remove('text-blue-700', 'font-medium');
                step.classList.add('text-gray-500');
            }
        });
        
        // Update submit button state
        submitButton.disabled = completedFields < totalRequired;
        submitButton.classList.toggle('opacity-50', completedFields < totalRequired);
        submitButton.classList.toggle('cursor-not-allowed', completedFields < totalRequired);
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        // Show loading spinner
        if (loadingSpinner) {
            loadingSpinner.classList.remove('hidden');
            submitButton.querySelector('span').classList.add('opacity-0');
        }
    });

    // Add sticky behavior to the progress bar
    window.addEventListener('scroll', function() {
        if (progressContainer) {
            if (window.pageYOffset > 100) {
                progressContainer.classList.add('scrolled');
            } else {
                progressContainer.classList.remove('scrolled');
            }
        }
    });

    // Initialize progress and indicators
    updateProgress();
    if (whyInterestedField && whyInterestedField.value) {
        countWords();
        updateWritingQuality();
    }
    if (skillsField && skillsField.value) {
        updateSkillMatch();
    }
});
    </script>

</x-app-layout>