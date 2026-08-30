@props([
    'post' => true
])

@php
    $method = $post ? 'POST' : 'GET'
@endphp

<form {{ $attributes->class(['flex flex-col gap-4']) }} method="{{ $method }}">
    @if($method === 'POST')
        @csrf
    @endif

    {{ $slot }}
</form>
