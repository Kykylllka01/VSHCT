<x-guest-layout>

    <div class="text-center mb-6">
        <h2 class="text-2xl font-semibold text-deep-blue">Создайте аккаунт</h2>
        <p class="text-slate-light text-sm mt-1">Присоединяйтесь к сообществу инноваций</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Имя -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-text">Имя</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-text">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Роль -->
        <fieldset>
            <legend class="block text-sm font-medium text-slate-text">Я...</legend>
            <div class="mt-2 grid grid-cols-2 gap-3">
                <!-- Студент -->
                <label class="relative flex flex-col items-center p-4 border-2 border-gray-200 rounded-2xl cursor-pointer bg-white transition hover:border-mint/50 role-label">
                    <input type="radio" name="role" value="student" class="role-radio sr-only" {{ old('role') === 'student' ? 'checked' : '' }} required>
                    <span class="text-3xl mb-1">🎓</span>
                    <span class="text-sm font-medium text-slate-text">Студент</span>
                </label>
                <!-- Преподаватель -->
                <label class="relative flex flex-col items-center p-4 border-2 border-gray-200 rounded-2xl cursor-pointer bg-white transition hover:border-mint/50 role-label">
                    <input type="radio" name="role" value="teacher" class="role-radio sr-only" {{ old('role') === 'teacher' ? 'checked' : '' }}>
                    <span class="text-3xl mb-1">👨‍🏫</span>
                    <span class="text-sm font-medium text-slate-text">Преподаватель</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
        </fieldset>

        <!-- Пароль -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-text">Пароль</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Подтверждение пароля -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-text">Подтверждение пароля</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Кнопка -->
        <button type="submit"
                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-deep-blue hover:bg-deep-blue/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-deep-blue transition duration-200 transform hover:scale-[1.01]">
            Зарегистрироваться
        </button>

        <div class="text-center text-sm text-slate-light">
            Уже есть аккаунт? <a href="{{ route('login') }}" class="font-medium text-deep-blue hover:text-mint underline decoration-mint/30 hover:decoration-mint">Войти</a>
        </div>
    </form>
</x-guest-layout>