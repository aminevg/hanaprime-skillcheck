@props(['title' => '', 'status' => null])

<x-layouts.root :title="$title">
    <header class="sticky top-0 z-40 w-full">
        <nav
            class="flex h-14 w-full items-center border-b bg-white px-6 py-3 backdrop-blur supports-[backdrop-filter]:bg-white/60">
            <div class="flex-grow">
                <a href="{{ route('diaries.index') }}"
                    class="flex items-center gap-1">
                    <x-ui.application-logo />
                </a>
            </div>
            <div class="flex justify-end gap-3">
                <x-ui.primary-button element="a"
                    href="{{ route('diaries.create') }}"
                    class="max-lg:hidden">日記を追加</x-ui.primary-button>

                <form id="logout-form" method="POST"
                    action="{{ route('login.destroy') }}">
                    @csrf
                    @method('delete')
                    <x-ui.destructive-button id="logout-form-submit-button"
                        type="submit">ログアウト</x-ui.destructive-button>
                </form>
                <script>
                    document.getElementById('logout-form').addEventListener('submit', () => {
                        const button = document.getElementById(
                            'logout-form-submit-button');
                        button.disabled = true;
                        button.dataset.loading = "true";
                    });
                </script>
            </div>
        </nav>
    </header>
    <main class="relative">
        {{ $slot }}

        @if (Route::currentRouteName() === 'diaries.index')
            <div class="fixed bottom-5 right-5 z-10 lg:hidden">
                <a href="{{ route('diaries.create') }}"
                    class="inline-flex h-16 w-16 items-center justify-center gap-2 whitespace-nowrap rounded-full bg-zinc-900 text-sm font-medium text-zinc-50 ring-offset-white transition-colors hover:bg-zinc-900/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 [&_svg]:pointer-events-none [&_svg]:size-8 [&_svg]:shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                        height="32" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z" />
                    </svg>
                </a>
            </div>
        @endif

        <x-ui.toast :status="$status" />
    </main>
</x-layouts.root>
