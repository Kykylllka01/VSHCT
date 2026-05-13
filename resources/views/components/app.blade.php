<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ВШЦТ') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script>
        window.authUserId = {{ Auth::id() ?? 'null' }};
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-warm-gray min-h-screen">
    <!-- Навигационная панель -->
    <nav class="bg-deep-blue border-b border-white/10 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Логотип и название -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <svg width="36" height="40" viewBox="0 0 44 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 4L40 14V34L22 44L4 34V14L22 4Z" fill="url(#gradNav)" stroke="white"
                                stroke-width="2" stroke-linejoin="round" />
                            <defs>
                                <linearGradient id="gradNav" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#1E3A5F; stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#00BFA6; stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="text-xl font-bold text-white tracking-wider">ВШЦТ</span>
                    </a>
                </div>

                <!-- Навигационные ссылки (центр) -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('ideas.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">
                        Идеи
                    </a>
                    <a href="{{ route('projects.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">
                        Проекты
                    </a>
                </div>

                <!-- Профиль и меню пользователя -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <!-- Выпадающее меню -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 z-50"
                        style="display: none;">
                        <a href="{{ route('profile.show', Auth::user()) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Мой профиль</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Выйти
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            {{ $slot }}
        </div>
    </main>
</body>

</html>