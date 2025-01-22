<x-layouts.authenticated title="日記を追加">
    <x-diaries.form title="日記を追加" label="追加" :action="route('diaries.store')" />
</x-layouts.authenticated>
