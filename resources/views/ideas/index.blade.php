<x-app-layout>
    <div class="animate-fade-in-up">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-deep-blue">Реестр идей</h1>
                <p class="text-slate-light mt-2">Поиск и отбор инновационных предложений</p>
            </div>
            <a href="{{ route('ideas.create') }}"
                class="inline-flex items-center px-4 py-2 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Подать идею
            </a>
        </div>
    </div>

    <!-- Поиск и фильтр -->
    <form method="GET" class="glass-card rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="input-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Поиск по названию, описанию или технологиям..."
                class="with-icon block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
        </div>
        <select name="status"
            class="border border-gray-200 rounded-xl shadow-sm py-2.5 px-4 focus:ring-2 focus:ring-mint/30 focus:border-mint">
            <option value="">Все статусы</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Опубликовано</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Одобрено</option>
            <option value="in_project" {{ request('status') === 'in_project' ? 'selected' : '' }}>В проекте</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Отклонено</option>
        </select>
        <button type="submit"
            class="px-6 py-2.5 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
            Найти
        </button>
    </form>

    <!-- Сетка идей -->
    @if($ideas->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($ideas as $idea)
                <div
                    class="glass-card rounded-2xl p-6 flex flex-col hover:shadow-xl transition duration-200 hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full
                                            @if($idea->status === 'approved') bg-mint/20 text-mint
                                            @elseif($idea->status === 'published') bg-blue-100 text-deep-blue
                                            @elseif($idea->status === 'in_project') bg-purple-100 text-purple-700
                                            @elseif($idea->status === 'pending') bg-gray-100 text-gray-600
                                            @elseif($idea->status === 'rejected') bg-red-100 text-red-600
                                            @endif">
                            @if($idea->status === 'approved') Одобрено
                            @elseif($idea->status === 'published') Опубликовано
                            @elseif($idea->status === 'in_project') В проекте
                            @elseif($idea->status === 'rejected') Отклонено
                            @else Черновик @endif
                        </span>
                        <span class="text-xs text-slate-light">{{ $idea->created_at->format('d.m.Y') }}</span>
                    </div>

                    <h3 class="text-lg font-semibold text-deep-blue mb-2 line-clamp-2">{{ $idea->title }}</h3>
                    <p class="text-sm text-slate-text line-clamp-3 mb-4 flex-1">{{ Str::limit($idea->problem, 120) }}</p>

                    @if($idea->technology_stack)
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(explode(',', $idea->technology_stack) as $tech)
                                <span class="text-xs bg-gray-100 text-slate-text px-2 py-0.5 rounded-full">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('ideas.show', $idea) }}"
                        class="mt-auto inline-flex items-center text-sm font-medium text-mint hover:text-deep-blue transition">
                        Подробнее
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-8">
            {{ $ideas->links() }}
        </div>
    @else
        <div class="glass-card rounded-2xl p-12 text-center text-slate-light">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            <p class="text-lg">Идей не найдено</p>
            <p class="text-sm mt-1">Попробуйте изменить параметры поиска или <a href="{{ route('ideas.create') }}"
                    class="text-mint font-medium">предложите новую идею</a>.</p>
        </div>
    @endif
</x-app-layout>