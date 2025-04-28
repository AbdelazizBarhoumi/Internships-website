@php
$classes = 'p-4 bg-white/5 rounded-xl border border-transparent';
@endphp
<div {{ $attributes(['class' => $classes]) }}> 
{{$slot}}
</div>  
