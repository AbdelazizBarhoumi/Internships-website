@props(['tags'])
@if($tags->count())
    <div class="mb-6 border-t pt-4">
        <h2 class="text-lg font-semibold mb-2">Skills & Requirements</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($tags as $tag)
                <x-tag :$tag />
            @endforeach
        </div>
    </div>
@endif