@props(['internship'])
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
        <p class="text-gray-700 font-semibold">Salary:</p>
        <p class="text-gray-800">{{ $internship->salary }}</p>
    </div>
    <div>
        <p class="text-gray-700 font-semibold">Location:</p>
        <p class="text-gray-800">{{ $internship->location }}</p>
    </div>
    <div>
        <p class="text-gray-700 font-semibold">Schedule:</p>
        <p class="text-gray-800">{{ $internship->schedule }}</p>
    </div>
    <div>
        <p class="text-gray-700 font-semibold">Company Website:</p>
        <a href="{{ $internship->url }}" class="text-blue-600 hover:underline" target="_blank">{{ $internship->url }}</a>
    </div>
</div>