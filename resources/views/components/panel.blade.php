@php
$classes = 'p-4 bg-black/10 rounded-xl border';
@endphp
<div {{ $attributes(['class' => $classes]) }}> 
{{$slot}}
</div>  
