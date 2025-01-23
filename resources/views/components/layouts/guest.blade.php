@props(['title' => ''])

<x-layouts.root :title="$title">
    <div class="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-6">
            <x-ui.application-logo :hide-on-mobile="false"
                class="flex items-center justify-center" />
            <x-ui.card :title="$title">
                {{ $slot }}
            </x-ui.card>
        </div>
    </div>
</x-layouts.root>
