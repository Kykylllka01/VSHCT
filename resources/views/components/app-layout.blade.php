<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'ВШЦТ') }}</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
  <!-- Навигационная панель -->
  <nav class="bg-deep-blue border-b border-white/10 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <!-- Логотип и название -->
        <div class="flex items-center space-x-3">
          <a href="{{ route('ideas.index') }}" class="flex items-center space-x-3">
            <svg width="36" height="40" viewBox="0 0 44 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22 4L40 14V34L22 44L4 34V14L22 4Z" fill="url(#gradNav)" stroke="white" stroke-width="2"
                stroke-linejoin="round" />
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
          <a href="{{ route('chat.index') }}"
            class="px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">
            Чаты
          </a>

          @auth
            @if(Auth::user()->isAdmin())
              <a href="{{ route('admin.statistics') }}"
                class="px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">
                Панель управления
              </a>
            @endif
          @endauth
        </div>

        <!-- Профиль и меню пользователя -->
        <div class="relative flex" x-data="{ open: false }">

          <!-- Колокольчик уведомлений -->
          <div class="relative mr-4"
            x-data="{ openNotif: false, unread: {{ Auth::user()->unreadNotifications->count() }} }">
            <button @click="openNotif = !openNotif"
              class="relative px-2 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span x-show="unread > 0"
                class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-alert-coral rounded-full"
                x-text="unread"></span>
            </button>

            <!-- Выпадающий список -->
            <div x-show="openNotif" @click.away="openNotif = false"
              x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
              x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg py-2 z-50 max-h-80 overflow-y-auto"
              style="display: none;">
              @if(Auth::user()->unreadNotifications->count())
                <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                  <span class="text-xs font-semibold text-slate-light">Новые уведомления</span>
                  <form method="POST" action="{{ route('notifications.markAllRead') }}" class="inline">
                    @csrf
                    <button type="submit"
                      class="text-xs text-mint hover:underline bg-transparent border-none p-0 cursor-pointer">
                      Прочитать все
                    </button>
                  </form>
                </div>
                @foreach(Auth::user()->unreadNotifications->take(5) as $notification)
                  <a href="{{ route('projects.show', $notification->data['project_id'] ?? 0) }}"
                    class="block px-4 py-3 hover:bg-gray-50 transition">
                    <p class="text-sm font-medium text-deep-blue">{{ $notification->data['message'] ?? 'Уведомление' }}</p>
                    <p class="text-xs text-slate-light mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                  </a>
                @endforeach
              @else
                <div class="px-4 py-6 text-center text-sm text-slate-light">Нет новых уведомлений</div>
              @endif
            </div>
          </div>

          <button @click="open = !open"
            class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">
            <span>{{ Auth::user()->name }}</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <!-- Выпадающее меню -->
          <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute  top-10 right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 z-50" style="display: none;">
            <a href="{{ route('profile.show', Auth::user()) }}"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Мой профиль</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Выйти
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Основной контент -->
  <main class="flex-1 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
      {{ $slot }}
    </div>
  </main>

  <!-- Футер -->
  <footer class="bg-deep-blue text-white/80 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- О платформе -->
        <div>
          <h3 class="text-lg font-semibold text-white mb-3">ВШЦТ</h3>
          <p class="text-sm text-white/60">Высшая школа цифровых технологий – платформа для управления проектами и
            идеями студентов.</p>
        </div>
        <!-- Навигация -->
        <div>
          <h3 class="text-lg font-semibold text-white mb-3">Разделы</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="{{ route('ideas.index') }}" class="hover:text-white transition">Реестр идей</a></li>
            <li><a href="{{ route('projects.index') }}" class="hover:text-white transition">Проекты</a></li>
            @auth
              <li><a href="{{ route('profile.show', Auth::user()) }}" class="hover:text-white transition">Мой профиль</a>
              </li>
            @endauth
          </ul>
        </div>
        <!-- Контакты -->
        <div>
          <h3 class="text-lg font-semibold text-white mb-3">Контакты</h3>
          <p class="text-sm text-white/60">Email: support@vshct.ru</p>
          <p class="text-sm text-white/60">Телефон: +7 (999) 123-45-67</p>
        </div>
      </div>
      <div class="mt-8 pt-6 border-t border-white/10 text-center text-sm text-white/40">
        &copy; {{ date('Y') }} ВШЦТ. Все права защищены.
      </div>
    </div>
  </footer>
</body>

</html>