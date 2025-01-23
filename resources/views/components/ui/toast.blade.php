@props(['status' => null])

@php
    $statusMessage = match ($status) {
        'diary-created' => '日記を追加しました。',
        'diary-updated' => '日記を編集しました。',
        'diary-deleted' => '日記を削除しました。',
        default => null,
    };
@endphp

@if ($statusMessage)
    <div
        class="fixed left-0 top-0 z-50 flex w-full items-center justify-center p-4 md:bottom-0 md:left-0 md:top-auto md:max-w-80">
        <div id="status-toast"
            class="relative w-full animate-show-toast cursor-pointer rounded-lg border bg-white p-6 pr-8 text-stone-950 shadow-lg transition-all duration-500 data-[hide=true]:translate-x-full data-[hide=true]:opacity-0 data-[hide=true]:md:-translate-x-full">
            {{ $statusMessage }}
        </div>
    </div>

    <script>
        const toastElement = document.getElementById('status-toast');
        const hideCallback = () => {
            toastElement.dataset.hide = true
        }

        toastElement.addEventListener('click', hideCallback);

        setTimeout(() => {
            toastElement.removeEventListener('click', hideCallback);
            hideCallback();
        }, 5000);
    </script>
@endif
