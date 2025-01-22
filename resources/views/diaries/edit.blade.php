<x-layouts.authenticated title="日記を編集">
    <x-diaries.form title="日記を編集" label="編集" :action="route('diaries.store')" method="patch"
        :diary="$diary" />
</x-layouts.authenticated>
