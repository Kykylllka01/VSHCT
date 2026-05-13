<x-app-layout>
    <div class="space-y-6">
        <!-- Заголовок и кнопка создания -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-deep-blue">Проекты</h1>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
                    Создать проект
                </a>
            @endcan
        </div>

        <!-- Поиск и фильтр -->
        <form method="GET" class="glass-card rounded-2xl p-4 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по названию проекта..."
                       class="with-icon block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
            </div>
            <select name="status" class="border border-gray-200 rounded-xl shadow-sm py-2.5 px-4 focus:ring-2 focus:ring-mint/30 focus:border-mint">
                <option value="">Все статусы</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Активные</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Завершённые</option>
            </select>
            <button type="submit" class="px-6 py-2.5 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
                Найти
            </button>
        </form>

        <!-- Сетка проектов (оставляем как было, но с пагинацией) -->
        @if($projects->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <div class="glass-card rounded-2xl p-6 hover:shadow-xl transition hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full 
                            {{ $project->status === 'active' ? 'bg-mint/20 text-mint' : 'bg-gray-100 text-gray-600' }}">
                            {{ $project->status === 'active' ? 'Активный' : 'Завершён' }}
                        </span>
                        <span class="text-xs text-slate-light">{{ $project->created_at->format('d.m.Y') }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-deep-blue mb-2">{{ $project->title }}</h3>
                    @if($project->idea)
                        <p class="text-sm text-slate-light">Основан на идее: {{ $project->idea->title }}</p>
                    @endif
                    <a href="{{ route('projects.show', $project) }}" class="mt-4 inline-flex items-center text-sm font-medium text-mint hover:text-deep-blue">
                        Подробнее
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                @endforeach
            </div>
            {{ $projects->links('pagination.custom') }}
        @else
            <div class="glass-card rounded-2xl p-12 text-center text-slate-light">
                <p class="text-lg">Проектов не найдено</p>
                @can('create', App\Models\Project::class)
                    <a href="{{ route('projects.create') }}" class="text-mint font-medium mt-2 inline-block">Создать первый проект</a>
                @endcan
            </div>
        @endif
    </div>
</x-app-layout>