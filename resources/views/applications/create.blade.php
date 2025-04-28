<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Apply for {{ $internship->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('applications.store', $internship) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Personal Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="availability" class="block text-sm font-medium text-gray-700">Available Start Date</label>
                                    <input type="date" name="availability" id="availability" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('availability') }}">
                                    @error('availability')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Education -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Education</h3>
                            
                            <div class="mb-4">
                                <label for="education" class="block text-sm font-medium text-gray-700">Current Education Level</label>
                                <select name="education" id="education" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select Education Level</option>
                                    <option value="high_school" {{ old('education') == 'high_school' ? 'selected' : '' }}>High School</option>
                                    <option value="associate" {{ old('education') == 'associate' ? 'selected' : '' }}>Associate Degree</option>
                                    <option value="bachelor" {{ old('education') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="master" {{ old('education') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                    <option value="phd" {{ old('education') == 'phd' ? 'selected' : '' }}>PhD</option>
                                </select>
                                @error('education')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="institution" class="block text-sm font-medium text-gray-700">Institution Name</label>
                                <input type="text" name="institution" id="institution" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('institution') }}">
                                @error('institution')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Skills & Experience</h3>
                            
                            <div class="mb-4">
                                <label for="skills" class="block text-sm font-medium text-gray-700">Relevant Skills</label>
                                <textarea name="skills" id="skills" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="List your relevant skills, separated by commas">{{ old('skills') }}</textarea>
                                @error('skills')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Required Documents</h3>
                            
                            <div class="mb-4">
                                <label for="resume" class="block text-sm font-medium text-gray-700">Resume (PDF)</label>
                                <input type="file" name="resume" id="resume" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                                @error('resume')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover Letter (Optional)</label>
                                <textarea name="cover_letter" id="cover_letter" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="transcript" class="block text-sm font-medium text-gray-700">Academic Transcript (Optional)</label>
                                <input type="file" name="transcript" id="transcript" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('transcript')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Why interested -->
                        <div class="mb-6">
                            <label for="why_interested" class="block text-sm font-medium text-gray-700">Why are you interested in this internship?</label>
                            <textarea name="why_interested" id="why_interested" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('why_interested') }}</textarea>
                            @error('why_interested')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex space-x-4 mt-8">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Submit Application
                            </button>
                            <a href="{{ route('internship.show', $internship) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>