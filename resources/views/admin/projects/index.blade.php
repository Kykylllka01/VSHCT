<x-admin-layout>
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-deep-blue">Управление проектами</h1>

        <!-- Поиск -->
        <form method="GET" class="glass-card rounded-2xl p-4 flex gap-3">
            <div class="relative flex-1">
                <span class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по названию проекта..."
                       class="with-icon block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-mint text-white font-medium rounded-xl hover:bg-mint/90 transition">
                Найти
            </button>
        </form>

        <!-- Таблица -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-deep-blue/5">
                    <tr>
                        <th class="px-6 py-3 text-left">Название</th>
                        <th class="px-6 py-3 text-left">Руководитель</th>
                        <th class="px-6 py-3 text-left">Статус</th>
                        <th class="px-6 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-white/50">
                            <td class="px-6 py-4">
                                <a href="{{ route('projects.show', $project) }}" class="font-medium text-deep-blue hover:text-mint transition">
                                    {{ $project->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-light">{{ $project->teacher->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $project->status === 'active' ? 'bg-mint/20 text-mint' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $project->status === 'active' ? 'Активен' : 'Завершён' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('projects.show', $project) }}" class="text-sm text-mint hover:underline">Просмотр</a>
                                <form method="POST" action="{{ route('admin.projects.close', $project) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm text-mint hover:underline">
                                        {{ $project->status === 'active' ? 'Завершить' : 'Активировать' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-light">Проектов не найдено</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($projects->hasPages())
                <div class="p-4">
                    {{ $projects->links('pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>