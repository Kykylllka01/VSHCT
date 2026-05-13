<x-admin-layout>
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-deep-blue">Управление идеями</h1>

        <div class="glass-card rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-deep-blue/5">
                    <tr>
                        <th class="px-6 py-3 text-left">Название</th>
                        <th class="px-6 py-3 text-left">Автор</th>
                        <th class="px-6 py-3 text-left">Статус</th>
                        <th class="px-6 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($ideas as $idea)
                        <tr class="hover:bg-white/50">
                            <td class="px-6 py-4 font-medium text-deep-blue">
                                <a href="{{ route('ideas.show', $idea) }}" class="hover:text-mint transition">
                                    {{ $idea->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-light">{{ $idea->user->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($idea->status === 'approved') bg-mint/20 text-mint
                                    @elseif($idea->status === 'published') bg-blue-100 text-deep-blue
                                    @elseif($idea->status === 'in_project') bg-purple-100 text-purple-700
                                    @elseif($idea->status === 'rejected') bg-red-100 text-red-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    @if($idea->status === 'approved') Одобрено
                                    @elseif($idea->status === 'published') Опубликовано
                                    @elseif($idea->status === 'in_project') В проекте
                                    @elseif($idea->status === 'rejected') Отклонено
                                    @else {{ $idea->status }} @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.ideas.destroy', $idea) }}" 
                                      onsubmit="return confirm('Удалить идею навсегда?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:underline">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-light">Идей пока нет.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($ideas->hasPages())
                <div class="p-4">
                    {{ $ideas->links('pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>