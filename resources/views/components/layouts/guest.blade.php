@props(['title' => ''])

<x-layouts.root :title="$title">
    <div class="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
        <div class="w-full max-w-sm">
            <x-guest.card :title="$title">{{ $slot }}</x-guest.card>
        </div>
    </div>
</x-layouts.root>
