@props(['message'])
@if($message)
    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        {{ $message }}
    </div>
@endif