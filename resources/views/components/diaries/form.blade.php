@props(['title', 'action', 'method' => 'post', 'label', 'diary' => null])

<div class="flex items-center justify-center p-6 md:p-10">
    <x-ui.card title="{{ $title }}" class="w-full max-w-sm">
        <form id="diary-form" action="{{ $action }}" method="POST">
            @csrf
            @if ($method !== 'post')
                @method($method)
            @endif

            <div class="flex flex-col gap-6">
                <div class="grid gap-2">
                    <x-form.input-label for="date">日付</x-form.input-label>
                    <x-form.input id="date" name="date" type="date"
                        :value="old(
                            'date',
                            ($diary?->created_at ?? today())->format('Y-m-d'),
                        )" :max="today()->format('Y-m-d')" required />
                    <x-form.input-error :message="$errors->get('date')" />
                </div>

                <div class="grid gap-2">
                    <x-form.input-label for="content">日記</x-form.input-label>
                    <x-form.input id="content" name="content"
                        :value="old('content', $diary?->content)" required maxlength="255" />
                    <x-form.input-error :message="$errors->get('content')" />
                </div>

                <div class="grid gap-2">
                    <x-form.input-label for="image">画像</x-form.input-label>
                    <x-form.input id="image" name="image" type="file"
                        accept="image/*" />
                    <x-form.input-error :message="$errors->get('image')" />
                </div>

                <x-ui.primary-button id="diary-form-submit-button"
                    type="submit" class="w-full transition-all">
                    {{ $label }}
                </x-ui.primary-button>
            </div>
        </form>
    </x-ui.card>
</div>
