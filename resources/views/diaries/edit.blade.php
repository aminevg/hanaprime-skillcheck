<x-layouts.authenticated title="日記を編集">
    <x-diaries.form title="日記を編集" label="保存" :action="route('diaries.update', ['diary' => $diary])" method="patch"
        :diary="$diary" />
</x-layouts.authenticated>
