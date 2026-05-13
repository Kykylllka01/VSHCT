<x-guest-layout subtitle="Подтверждение почты">
    <div class="text-sm text-gray-600 mb-6">
        {{ __('На ваш email отправлен 6-значный код. Введите его ниже, чтобы подтвердить аккаунт.') }}
    </div>

    <form method="POST" action="{{ route('verification.code.verify') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- Код -->
        <div>
            <x-input-label for="code" :value="__('Код подтверждения')" />
            <x-text-input id="code" class="block mt-1 w-full form-input text-center text-2xl tracking-widest" type="text" name="code" required maxlength="6" placeholder="000000" autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full justify-center">
            {{ __('Подтвердить') }}
        </button>

        <div class="text-center text-sm text-gray-600">
            <span>Не получили код? </span>
            <button type="button" id="resend-code-btn" class="underline text-indigo-600 hover:text-indigo-800" disabled>
                Отправить код повторно через 30 сек
            </button>
        </div>
    </form>
</x-guest-layout>