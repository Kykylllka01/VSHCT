<x-app-layout>
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-deep-blue">Проекты</h1>
        @can('create', App\Models\Project::class)
        <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
            Создать проект
        </a>
        @endcan
    </div>

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
        {{ $projects->links() }}
    @else
        <div class="glass-card rounded-2xl p-12 text-center text-slate-light">Нет проектов</div>
    @endif
</x-app-layout>