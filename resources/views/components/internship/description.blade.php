@props(['internship'])
<div class="prose max-w-none">
    {!! nl2br(e($internship->description)) !!}
    
    @if($internship->duration)
        <div class="mt-4">
            <p class="font-medium">Duration: <span class="font-normal">{{ $internship->duration }}</span></p>
        </div>
    @endif
</div>