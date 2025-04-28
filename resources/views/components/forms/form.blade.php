<form {{ $attributes->merge(["class" => "space-y-6"]) }}>
    @csrf
    @if ($attributes->has('method') && strtolower($attributes->get('method')) !== 'get' && strtolower($attributes->get('method')) !== 'post')
        @method($attributes->get('method'))
    @endif

    {{ $slot }}
</form>