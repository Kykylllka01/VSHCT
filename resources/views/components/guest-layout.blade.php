<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ВШЦТ') }}</title>

    <!-- Шрифт Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-400 via-cyan-500 to-teal-400 min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden">

    <!-- Декоративные круги на фоне -->
    <div class="absolute top-0 left-1/4 w-72 h-72 bg-mint rounded-full bg-blur-circle"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-400 rounded-full bg-blur-circle"></div>
    <div class="absolute top-1/3 right-1/3 w-64 h-64 bg-yellow-200 rounded-full bg-blur-circle" style="animation-delay: 3s;"></div>

    <div class="relative w-full max-w-md mx-auto">
        <!-- Логотип -->
        <div class="text-center mb-8">
            <!-- SVG-сота + текст «ВШЦТ» -->
            <div class="inline-flex items-center gap-3">
                <!-- Минималистичный шестиугольник (сота) -->
                <svg width="44" height="48" viewBox="0 0 44 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 4L40 14V34L22 44L4 34V14L22 4Z" fill="url(#grad)" stroke="white" stroke-width="2" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#1E3A5F; stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00BFA6; stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
                <h1 class="text-3xl font-bold text-white tracking-wider">ВШЦТ</h1>
            </div>
            <p class="text-white/80 text-sm mt-2 tracking-wide">Высшая школа цифровых технологий</p>
        </div>

        <!-- Стеклянная карточка -->
        <div class="glass-card rounded-2xl shadow-2xl p-8 animate-fade-in-up">
            {{ $slot }}
        </div>
    </div>
</body>
</html>