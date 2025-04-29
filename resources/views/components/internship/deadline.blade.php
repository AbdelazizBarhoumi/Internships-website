@props(['internship'])
@if($internship->deadline_date)
    <div class="mb-6 bg-blue-50 p-4 rounded-lg">
        <div class="flex items-center gap-2">
            <x-icon.calendar class="h-5 w-5 text-blue-500" />
            <span class="font-medium">Application deadline_date:</span>
            {{ $internship->deadline_date->format('F j, Y') }}
            @if(!$internship->deadline_date->isPast())
                <span class="text-sm text-gray-500">({{ $internship->deadline_date->diffForHumans() }})</span>
            @endif
        </div>
    </div>
@endif