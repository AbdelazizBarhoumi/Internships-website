@props(['width' => 90, 'employer'])
<img src="{{ asset($employer->employer_logo) }}" class="rounded-xl" width="{{ $width }}" height="{{ $width }}" loading="lazy">
