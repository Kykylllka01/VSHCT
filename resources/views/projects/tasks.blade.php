<x-app-layout>
    <div class="glass-card rounded-2xl p-6">
        <h1 class="text-2xl font-semibold text-deep-blue mb-6">Задачи проекта «{{ $project->title }}»</h1>

        <h2 class="text-lg font-medium mb-3">Добавить задачу</h2>
        <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="space-y-4 mb-8">
            @csrf
            <input name="title" placeholder="Название задачи" required class="w-full px-4 py-2 border border-gray-200 rounded-xl">
            <textarea name="description" placeholder="Описание" rows="2" class="w-full px-4 py-2 border border-gray-200 rounded-xl"></textarea>
            <div class="flex space-x-3">
                <select name="assigned_to" class="border border-gray-200 rounded-xl px-4 py-2 flex-1">
                    <option value="">Не назначать</option>
                    @foreach($project->team as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="deadline" class="border border-gray-200 rounded-xl px-4 py-2">
            </div>
            <button type="submit" class="px-4 py-2 bg-mint text-white font-medium rounded-xl hover:bg-mint/90 text-sm">Добавить</button>
        </form>

        <h2 class="text-lg font-medium mb-3">Список задач</h2>
        <div class="space-y-3">
            @foreach($project->tasks as $task)
                <div class="flex items-center justify-between bg-white/50 p-3 rounded-xl">
                    <div>
                        <span class="font-medium">{{ $task->title }}</span>
                        <span class="text-xs text-slate-light ml-2">{{ $task->assignee->name ?? 'Нет' }}</span>
                    </div>
                    <form method="POST" action="{{ route('projects.tasks.status', [$project, $task]) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-3 py-1 text-sm">
                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>К выполнению</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Готово</option>
                        </select>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>