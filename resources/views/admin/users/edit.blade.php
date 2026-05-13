<x-admin-layout>
    <div class="glass-card rounded-2xl p-6 md:p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-semibold text-deep-blue mb-6">Изменить роль пользователя</h1>
        <p class="text-slate-light mb-4">{{ $user->name }} ({{ $user->email }})</p>

        <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-slate-text">Роль</label>
                <select name="role" id="role" class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Студент</option>
                    <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Преподаватель</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Администратор</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition w-full">
                Сохранить
            </button>
        </form>
    </div>
</x-admin-layout>