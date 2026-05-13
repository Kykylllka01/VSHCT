<x-app-layout>
    <!-- Приветствие -->
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold text-deep-blue">Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-light mt-2">Отслеживайте идеи, проекты и свою активность.</p>
    </div>

    <!-- Виджеты статистики -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Идеи -->
        <div class="glass-card rounded-2xl p-6 flex items-center space-x-4 animate-fade-in-up">
            <div class="flex-shrink-0 w-12 h-12 bg-mint/10 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-light">Всего идей</p>
                <p class="text-2xl font-semibold text-deep-blue">{{ $totalIdeas ?? 0 }}</p>
            </div>
        </div>

        <!-- Проекты -->
        <div class="glass-card rounded-2xl p-6 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-deep-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-light">Активных проектов</p>
                <p class="text-2xl font-semibold text-deep-blue">{{ $activeProjects ?? 0 }}</p>
            </div>
        </div>

        <!-- Задачи -->
        <div class="glass-card rounded-2xl p-6 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-light">Задач в работе</p>
                <p class="text-2xl font-semibold text-deep-blue">{{ $myTasks ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Последние идеи / активность -->
    <div class="glass-card rounded-2xl p-6 animate-fade-in-up" style="animation-delay: 0.3s;">
        <h2 class="text-xl font-semibold text-deep-blue mb-4">Последние идеи</h2>
        @if(isset($latestIdeas) && count($latestIdeas) > 0)
            <ul class="space-y-3">
                @foreach($latestIdeas as $idea)
                    <li class="p-3 bg-white/60 rounded-xl shadow-sm">
                        <a href="{{ route('ideas.show', $idea) }}" class="font-medium text-deep-blue hover:text-mint">{{ $idea->title }}</a>
                        <span class="text-sm text-slate-light ml-2">{{ $idea->status }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-slate-light">Пока нет ни одной идеи. <a href="{{ route('ideas.create') }}" class="text-mint font-medium">Предложите первую!</a></p>
        @endif
    </div>
</x-app-layout>