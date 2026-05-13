<x-app-layout>
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-deep-blue">Чаты</h1>

        @if($projects->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <a href="{{ route('chat.show', $project) }}" 
                       class="glass-card rounded-2xl p-6 hover:shadow-xl transition hover:-translate-y-1">
                        <h3 class="text-lg font-semibold text-deep-blue mb-2">{{ $project->title }}</h3>
                        <p class="text-sm text-slate-light">
                            {{ $project->status === 'active' ? 'Активный проект' : 'Завершённый проект' }}
                        </p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="glass-card rounded-2xl p-12 text-center text-slate-light">
                <p class="text-lg">У вас пока нет доступных чатов.</p>
                <p class="text-sm mt-2">Когда вы станете участником или руководителем проекта, здесь появятся чаты.</p>
            </div>
        @endif
    </div>
</x-app-layout>