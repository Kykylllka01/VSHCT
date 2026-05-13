<x-app-layout>
    <div class="glass-card rounded-2xl p-6">
        <h1 class="text-2xl font-semibold text-deep-blue mb-6">Команда проекта «{{ $project->title }}»</h1>

        <h2 class="text-lg font-medium mb-2">Текущие участники</h2>
        <ul class="space-y-2 mb-6">
            @foreach($project->team as $member)
                <li class="flex items-center justify-between bg-white/50 p-2 rounded-xl">
                    <span>{{ $member->name }}</span>
                    <form method="POST" action="{{ route('projects.team.remove', [$project, $member]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm text-red-500 hover:underline">Удалить</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <h2 class="text-lg font-medium mb-2">Добавить студента</h2>
        <form method="POST" action="{{ route('projects.team.add', $project) }}" class="flex items-end space-x-3">
            @csrf
            <select name="user_id" class="border border-gray-200 rounded-xl px-4 py-2 flex-1">
                <option value="">Выберите студента</option>
                @foreach($availableStudents as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-mint text-white font-medium rounded-xl hover:bg-mint/90 text-sm">Добавить</button>
        </form>
    </div>
</x-app-layout>