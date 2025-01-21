@props(['title' => ''])

<x-layouts.root :title="$title">
    <header class="sticky top-0 z-50 w-full">
        <nav
            class="flex h-14 w-full items-center border-b bg-white px-6 py-3 backdrop-blur supports-[backdrop-filter]:bg-white/60">
            <div class="flex-grow">
                <a href="{{ route('diaries.index') }}"
                    class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                        height="32" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M7 14v-2h10v2zm0 4v-2h7v2zm-2 4q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5z" />
                    </svg>
                    <span
                        class="hidden text-2xl font-semibold lg:inline-block">1行日記</span>
                </a>
            </div>
            <div class="flex justify-end gap-3">
                <x-ui.primary-button element="a" href="#"
                    class="max-lg:hidden">日記を追加</x-ui.primary-button>
                <form method="POST" action="{{ route('login.destroy') }}">
                    @csrf
                    @method('delete')
                    <x-ui.destructive-button
                        type="submit">ログアウト</x-ui.destructive-button>
                </form>
            </div>
        </nav>
    </header>
    <main class="relative">
        {{ $slot }}
        <div class="fixed bottom-5 right-5 z-10 lg:hidden">
            <a href="#"
                class="inline-flex h-16 w-16 items-center justify-center gap-2 whitespace-nowrap rounded-full bg-zinc-900 text-sm font-medium text-zinc-50 ring-offset-white transition-colors hover:bg-zinc-900/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 [&_svg]:pointer-events-none [&_svg]:size-8 [&_svg]:shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="32"
                    height="32" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z" />
                </svg>
            </a>
        </div>
    </main>
</x-layouts.root>
