<x-layout>
  <x-page-heading>Edit Internship</x-page-heading>

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

  <x-forms.form method="POST" action="{{ route('myinternship.update', $internship) }}">
    @csrf
    @method('PATCH')
    
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-forms.input 
          name="title" 
          label="Position Title" 
          required 
          placeholder="e.g. Marketing Intern"
          :value="$internship->title"
        />
        
        <x-forms.input 
          name="salary" 
          label="Salary/Stipend" 
          required 
          placeholder="e.g. $1,500/month"
          :value="$internship->salary"
        />
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <x-forms.input 
          name="location" 
          label="Location" 
          required 
          placeholder="e.g. New York, NY"
          :value="$internship->location"
        />
        <!-- Debugging output for location -->
        <x-forms.select 
          label="Schedule" 
          name="schedule" 
          required
        >
        <option value="Full-time" @selected($internship->schedule == "Full-time")>Full Time</option>
  <option value="Part-time" @selected($internship->schedule == "Part-time")>Part Time</option>
  <option value="Remote" @selected($internship->schedule == "Remote")>Remote</option>
  <option value="Hybrid" @selected($internship->schedule == "Hybrid")>Hybrid</option>
        </x-forms.select>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <x-forms.input 
          name="url" 
          label="Company Website" 
          required 
          placeholder="e.g. https://example.com"
          :value="$internship->url"
        />
        
        <x-forms.input 
          name="duration" 
          label="Duration" 
          placeholder="e.g. 3 months, Summer 2025"
          :value="$internship->duration"
        />
      </div>

      <div class="mt-4">
        <x-forms.textarea 
          name="description" 
          label="Internship Description" 
          rows="6" 
          required
          placeholder="Describe the internship, responsibilities, and what candidates will learn..."
        >{{ $internship->description }}</x-forms.textarea>
      </div>

      <div class="mt-4">
        <x-forms.input 
          name="tags" 
          label="Skills & Requirements (comma separated)" 
          placeholder="e.g. JavaScript, Marketing, Adobe Photoshop, ..."
          :value="$internship->tags->pluck('name')->implode(', ')"
        />
      </div>
      <div class="mt-6">
      @if ($internship->featured)
        <x-forms.checkbox 
        label="Feature (Cost Extra)" 
        name="featured"
        :checked='1' 
        />
        <p class="text-sm text-gray-500 mt-1">Additional fee of $29.99 applies for featured listings.</p>
      @else
        <x-forms.checkbox 
          label="Feature (Cost Extra)" 
          name="featured"
        />
      @endif
      </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-lg font-medium text-gray-900 mb-4">Application Settings</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-forms.input 
          type="date" 
          name="deadline" 
          label="Application Deadline" 
          placeholder="Select a deadline (optional)"
          :value="$internship->deadline ? $internship->deadline->format('Y-m-d') : ''"
        />
        
        <x-forms.input 
          name="positions" 
          label="Number of Positions" 
          type="number" 
          min="1" 
          placeholder="e.g. 2"
          :value="$internship->positions"
        />
      </div>
    </div>

    <div class="flex justify-between items-center">
      <a href="{{ route('myinternship.show', $internship) }}" class="text-gray-600 hover:text-gray-900">
        Cancel
      </a>
      <x-forms.button>Update Internship</x-forms.button>
    </div>
  </x-forms.form>
</x-layout>