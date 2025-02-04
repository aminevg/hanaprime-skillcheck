<x-layouts.guest title="ログイン">
    <form id="login-form" action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="flex flex-col gap-6">
            <div class="grid gap-2">
                <x-form.input-label for="email">メールアドレス</x-form.input-label>
                <x-form.input id="email" name="email" type="email"
                    :value="old('email')" placeholder="test@example.com" required
                    autofocus autocomplete='email' />
                <x-form.input-error :message="$errors->get('email')" />
            </div>

            <div class="grid gap-2">
                <x-form.input-label for="password">パスワード</x-form.input-label>
                <x-form.input id="password" name="password" type="password"
                    required autocomplete="current-password" />
                <x-form.input-error :message="$errors->get('password')" />
            </div>

            <div class="flex items-center space-x-2">
                <x-form.checkbox id="remember_me" name="remember_me" />
                <x-form.input-label
                    for="remember_me">次回以降はパスワードを省略する</x-form.input-label>
            </div>

            <x-ui.primary-button id="login-form-submit-button" type="submit"
                class="w-full">
                ログイン
            </x-ui.primary-button>
        </div>
    </form>
</x-layouts.guest>

<script>
    document.getElementById("login-form").addEventListener('submit',
        () => {
            const button = document.getElementById(
                "login-form-submit-button");
            button.disabled = true;
            button.dataset.loading = "true";
        });
</script>
