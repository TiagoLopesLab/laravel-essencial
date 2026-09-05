@props(['name', 'label', 'checked' => false])

<label for="{{ $name }}" class="inline-flex items-center">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        @if($checked) checked @endif
        {{ $attributes->class('rounded bg-gray-900') }}
    >
    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $label }}</span>
</label>
