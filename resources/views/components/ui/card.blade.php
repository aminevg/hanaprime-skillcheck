@props(['title'])

<div
    {{ $attributes->merge(['class' => 'rounded-lg border bg-white text-stone-950 shadow-sm']) }}>
    <div class="flex flex-col space-y-1.5 p-6">
        @isset($title)
            <div class="text-2xl font-semibold leading-none tracking-tight">
                {{ $title }}
            </div>
        @endisset
    </div>
    <div class="p-6 pt-0">
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="flex items-center p-6 pt-0">
            {{ $footer }}
        </div>
    @endisset
</div>
