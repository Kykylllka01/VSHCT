<x-admin-layout>
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-deep-blue">Управление пользователями</h1>

        <!-- Поиск и фильтр -->
        <form method="GET" class="glass-card rounded-2xl p-4 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по имени или email..."
                       class="with-icon block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
            </div>
            <select name="role" class="border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-mint/30 focus:border-mint">
                <option value="">Все роли</option>
                <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Студент</option>
                <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Преподаватель</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Администратор</option>
            </select>
            <button type="submit" class="px-6 py-2.5 bg-mint text-white font-medium rounded-xl hover:bg-mint/90 transition">
                Найти
            </button>
        </form>

        <!-- Таблица -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-deep-blue/5">
                    <tr>
                        <th class="px-6 py-3 text-left text-slate-text">Имя</th>
                        <th class="px-6 py-3 text-left text-slate-text">Email</th>
                        <th class="px-6 py-3 text-left text-slate-text">Роль</th>
                        <th class="px-6 py-3 text-right text-slate-text">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/50">
                            <td class="px-6 py-4 font-medium text-deep-blue">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-slate-light">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($user->role === 'admin') bg-purple-100 text-purple-700
                                    @elseif($user->role === 'teacher') bg-blue-100 text-blue-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ $user->role === 'admin' ? 'Админ' : ($user->role === 'teacher' ? 'Преподаватель' : 'Студент') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-sm text-mint hover:underline">
                                    Изменить роль
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-light">Пользователей не найдено</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($users->hasPages())
                <div class="p-4">
                    {{ $users->links('pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>