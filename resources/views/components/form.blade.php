@props([
    'method' => 'POST'
])

@php
    $method = strtoupper($method);
    if (!in_array($method, ['GET', 'POST', 'DELETE', 'PUT'])) {
        $method = 'POST';
    }
    $formMethod = $method === 'GET' ? 'GET' : 'POST';
@endphp

<form {{ $attributes->class(['flex flex-col gap-4']) }} method="{{ $formMethod }}">
    @if($method !== 'GET')
        @csrf

        @if($method !== 'POST')
            @method($method)
        @endif
    @endif

    {{ $slot }}
</form>
