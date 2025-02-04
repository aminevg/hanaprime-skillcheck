@props(['element' => 'button'])

<{{ $element }} data-loading="false"
    {{ $attributes->merge(['class' => 'group inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-50 ring-offset-white transition-all duration-300 hover:bg-zinc-900/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0']) }}>
    <x-icons.loading class="animate-spin group-data-[loading=false]:hidden" />
    {{ $slot }}
</{{ $element }}>
