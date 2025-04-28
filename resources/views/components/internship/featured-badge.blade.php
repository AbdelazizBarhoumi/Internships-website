@props(['internship'])
@if($internship->featured)
    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold mb-2">Featured Opportunity</span>
@endif