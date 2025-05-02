<x-layout :showHero="false">
  <x-page-heading>Create New Internship</x-page-heading>

  @if ($errors->any())
    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 01-1-1v-4a1 1 0 112 0v4a1 1 0 01-1 1z" clip-rule="evenodd"></path>
        </svg>
        <p class="font-bold">Please fix the following errors:</p>
      </div>
      <ul class="list-disc ml-8 mt-2">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <x-forms.form method="POST" action="{{ route('internship.store') }}">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
      <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
        </svg>
        Basic Information
      </h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-forms.input name="title" label="Position Title" required placeholder="e.g. Marketing Intern"/>
        <x-forms.input name="salary" label="Salary/Stipend" required placeholder="e.g. $1,500/month"/>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <x-forms.input name="location" label="Location" required placeholder="e.g. New York, NY"/>
        <x-forms.select label="Schedule" name="schedule" required>
          <option value="" @selected(!old('schedule'))>Select schedule type</option>
          <option value="Full-time" @selected(old('schedule') == "Full-time")>Full Time</option>
          <option value="Part-time" @selected(old('schedule') == "Part-time")>Part Time</option>
          <option value="Remote" @selected(old('schedule') == "Remote")>Remote</option>
          <option value="Hybrid" @selected(old('schedule') == "Hybrid")>Hybrid</option>
        </x-forms.select>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <x-forms.input name="duration" label="Duration" placeholder="e.g. 3 months, Summer 2025"
          title="Specify how long the internship will last"/>
      </div>

      <div class="mt-4">
        <x-forms.textarea name="description" label="Internship Description" rows="6"
          placeholder="Describe the internship, responsibilities, and what candidates will learn..."></x-forms.textarea>
        <p class="text-xs text-gray-500 mt-1">Pro tip: Be specific about day-to-day responsibilities and learning opportunities to attract qualified candidates.</p>
      </div>

      <div class="mt-4">
        <x-forms.input name="tags" label="Skills & Requirements (comma separated)" 
          placeholder="e.g. JavaScript, Marketing, Adobe Photoshop, ..."
          title="These tags help candidates find your listing"/>
        <p class="text-xs text-gray-500 mt-1">Add relevant skills to increase visibility in search results</p>
      </div>

      <div class="mt-6 bg-blue-50 p-3 rounded-md border border-blue-100">
        <x-forms.checkbox label="Feature this internship (Premium placement in search results)" name="featured"/>
        <p class="text-sm text-gray-600 mt-1">Additional fee of $29.99 applies for featured listings. Featured listings receive 5x more applications on average.</p>
      </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
      <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
        </svg>
        Application Settings
      </h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-forms.input type="date" name="deadline_date" label="Application Deadline" 
          placeholder="Select a deadline (optional)"
          title="After this date, candidates can no longer apply"/>
      </div>
    </div>

    <div class="flex justify-between items-center">
      <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Cancel
      </a>
      <x-forms.button>
        <span class="flex items-center">
          Publish Internship
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
          </svg>
        </span>
      </x-forms.button>
    </div>
  </x-forms.form>
</x-layout>