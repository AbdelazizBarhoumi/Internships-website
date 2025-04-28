@props(['internship'])
<div class="mb-6 border-t pt-4">
    <h2 class="text-xl font-semibold mb-2 ">Description</h2>
    <div class="prose max-w-none text-gray-700 break-words whitespace-pre-wrap pr-4 pl-4">
        {!! nl2br(e($internship->description)) ?? 'No description provided.' !!}
    </div>
</div>