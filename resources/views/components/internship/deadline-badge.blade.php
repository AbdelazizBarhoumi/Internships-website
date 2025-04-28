@props(['internship'])
@if($internship->deadline)
    @if($internship->deadline->isPast())
        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Application Closed</span>
    @elseif($internship->deadline->diffInDays() < 3)
        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-semibold">Closing Soon</span>
    @endif
@endif