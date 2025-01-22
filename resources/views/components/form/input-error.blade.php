@props(['message'])

@if ($message)
    <p
        {{ $attributes->merge(['class' => 'text-sm font-medium text-red-500']) }}>
        {{ is_array($message) ? collect($message)->first() : $message }}
    </p>
@endif
