<x-guest-layout>

    <!-- Текст приветствия внутри карточки -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-semibold text-deep-blue">Вход в аккаунт</h2>
        <p class="text-slate-light text-sm mt-1">Добро пожаловать в экосистему проектов</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-text">Email</label>
            <div class="mt-1 relative">
                <span class="input-icon">
                    <!-- Иконка конверта -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="with-icon block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Пароль -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-text">Пароль</label>
            <div class="mt-1 relative">
                <span class="input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="with-icon block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Запомнить -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="h-4 w-4 rounded border-gray-300 text-mint focus:ring-mint">
            <label for="remember_me" class="ml-2 text-sm text-slate-text">Запомнить меня</label>
        </div>

        <!-- Кнопка -->
        <button type="submit"
                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-mint hover:bg-mint/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-mint transition duration-200 transform hover:scale-[1.01]">
            Войти
        </button>

        <div class="text-center text-sm text-slate-light">
            Нет аккаунта? <a href="{{ route('register') }}" class="font-medium text-deep-blue hover:text-mint underline decoration-mint/30 hover:decoration-mint">Зарегистрироваться</a>
        </div>
    </form>
</x-guest-layout>