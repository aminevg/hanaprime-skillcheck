<x-layouts.authenticated title="一覧ページ">
    <div
        class="grid grid-cols-1 justify-items-center gap-5 p-5 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">

        @forelse ($diaries as $diary)
            <x-ui.card :title="$diary['title']">
                <div class="flex h-full flex-col">
                    @if ($diary['image_path'])
                        <img src="{{ $diary['image_path'] }}" class="h-60 w-80 rounded-lg" />
                    @else
                        <div
                            class="flex h-60 w-80 items-center justify-center rounded-lg border text-stone-950 opacity-50">
                            画像は登録されていません。
                        </div>
                    @endif
                    <p class="line-clamp-2 h-[2lh] max-w-80 leading-7">
                        {{ $diary['content'] }}</p>
                </div>
                <x-slot:footer>
                    <div class="flex w-full justify-between">
                        <x-ui.primary-button element="a"
                            :href="route('diaries.edit', [
                                'diary' => $diary['id'],
                            ])">編集</x-ui.primary-button>
                        <x-ui.destructive-button>削除</x-ui.destructive-button>
                    </div>
                </x-slot:footer>
            </x-ui.card>
        @empty
            <p class="col-span-full">日記が追加されていません。</p>
        @endforelse
    </div>

    <x-ui.pagination :paginator="$diaries" class="py-8" />
</x-layouts.authenticated>
