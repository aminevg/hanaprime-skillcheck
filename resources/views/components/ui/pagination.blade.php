{{-- 
Inspired from:
- The default pagination implementation in Laravel:
https://github.com/illuminate/pagination/blob/master/resources/views/tailwind.blade.php
- The shadcn/ui pagination implementation:
https://ui.shadcn.com/docs/components/pagination
--}}

@props(['paginator'])

@php
    $window = \Illuminate\Pagination\UrlWindow::make($paginator);

    $elements = array_filter([
        $window['first'],
        is_array($window['slider']) ? '...' : null,
        $window['slider'],
        is_array($window['last']) ? '...' : null,
        $window['last'],
    ]);
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="pagination"
        {{ $attributes->merge(['class' => 'mx-auto flex w-full justify-center']) }}>
        <ul class="flex flex-row items-center gap-1">
            <li>
                <a href="{{ $paginator->previousPageUrl() ?? '#' }}"
                    rel="prev" aria-label="{{ __('pagination.previous') }}"
                    aria-disabled="{{ $paginator->onFirstPage() ? 'true' : 'false' }}"
                    @class([
                        'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0',
                        'hover:bg-zinc-100 hover:text-zinc-900 h-10 px-4 py-2 gap-1 pl-2.5',
                        'border border-zinc-200 bg-white' => $paginator->onFirstPage(),
                        'pointer-events-none cursor-default opacity-50' => $paginator->onFirstPage(),
                    ])>{!! __('pagination.previous') !!}</a>
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="hidden md:list-item">
                        <span aria-hidden
                            class="flex h-9 w-9 items-center justify-center">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="hidden md:list-item">
                            <a href="{{ $url }}"
                                aria-current="{{ $page == $paginator->currentPage() ? 'page' : 'false' }}"
                                @class([
                                    'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0',
                                    'hover:bg-zinc-100 hover:text-zinc-900 h-10 w-10',
                                    'border border-zinc-200 bg-white' => $page == $paginator->currentPage(),
                                    'pointer-events-none cursor-default opacity-50' =>
                                        $page == $paginator->currentPage(),
                                ])>{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li>
                <a href="{{ $paginator->nextPageUrl() ?? '#' }}" rel="next"
                    aria-label="{{ __('pagination.next') }}"
                    aria-disabled="{{ $paginator->onLastPage() ? 'true' : 'false' }}"
                    @class([
                        'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0',
                        'hover:bg-zinc-100 hover:text-zinc-900 h-10 px-4 py-2 gap-1 pr-2.5',
                        'border border-zinc-200 bg-white' => $paginator->onLastPage(),
                        'pointer-events-none cursor-default opacity-50' => $paginator->onLastPage(),
                    ])>{!! __('pagination.next') !!}</a>
            </li>
        </ul>
    </nav>
@endif
