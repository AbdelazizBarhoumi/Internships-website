@props(['internship'])
@if($internship->deadline)
    <div class="mb-6 bg-blue-50 p-4 rounded-lg">
        <div class="flex items-center gap-2">
            <x-icon.calendar class="h-5 w-5 text-blue-500" />
            <span class="font-medium">Application Deadline:</span>
            {{ $internship->deadline->format('F j, Y') }}
            @if(!$internship->deadline->isPast())
                <span class="text-sm text-gray-500">({{ $internship->deadline->diffForHumans() }})</span>
            @endif
        </div>
    </div>
@endif