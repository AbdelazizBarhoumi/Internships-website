<x-layout>
  <x-page-heading>Create New Internship</x-page-heading>

  @if ($errors->any())
    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
      <p class="font-bold">Please fix the following errors:</p>
      <ul class="list-disc ml-4">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <x-forms.form method="POST" action="{{ route('internship.store') }}">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>
      
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
        <x-forms.input name="duration" label="Duration" placeholder="e.g. 3 months, Summer 2025"/>
      </div>

      <div class="mt-4">
        <x-forms.textarea name="description" label="Internship Description" rows="6" required
          placeholder="Describe the internship, responsibilities, and what candidates will learn..."></x-forms.textarea>
      </div>

      <div class="mt-4">
        <x-forms.input name="tags" label="Skills & Requirements (comma separated)" 
          placeholder="e.g. JavaScript, Marketing, Adobe Photoshop, ..."/>
      </div>

      <div class="mt-6">
        <x-forms.checkbox label="Feature this internship (Premium placement in search results)" name="featured"/>
        <p class="text-sm text-gray-500 mt-1">Additional fee of $29.99 applies for featured listings.</p>
      </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-lg font-medium text-gray-900 mb-4">Application Settings</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-forms.input type="date" name="deadline_date" label="Application deadline_date" 
          placeholder="Select a deadline_date (optional)"/>
        <x-forms.input name="positions" label="Number of Positions" type="number" min="1" 
          placeholder="e.g. 2"/>
      </div>
<div class="mt-4">
  <x-forms.checkbox 
    label="Collect cover letters from applicants" 
    name="require_cover_letter"
    :checked="old('require_cover_letter')"
  />
</div>

<div class="mt-2">
  <x-forms.checkbox 
    label="Collect academic transcripts from applicants" 
    name="require_transcript"
    :checked="old('require_transcript')"
  />
</div>
    </div>

    <div class="flex justify-between items-center">
      <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
        Cancel
      </a>
      <x-forms.button>Publish Internship</x-forms.button>
    </div>
  </x-forms.form>
</x-layout>