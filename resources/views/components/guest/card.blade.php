@props(['title'])

<div class="rounded-lg border bg-white text-stone-950 shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
        @isset($title)
            <h1 class="text-2xl font-semibold leading-none tracking-tight">
                {{ $title }}
            </h1>
        @endisset
    </div>
    <div class="p-6 pt-0">
        {{ $slot }}
    </div>
</div>
