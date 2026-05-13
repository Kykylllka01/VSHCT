<x-app-layout>
  <div class="glass-card rounded-2xl p-6 md:p-8">
    <div class="flex justify-between items-start mb-6">
      <div>
        <h1 class="text-3xl font-bold text-deep-blue">{{ $project->title }}</h1>
        @if($project->idea)
          <p class="text-slate-light">Основан на идее: <a href="{{ route('ideas.show', $project->idea) }}"
              class="text-mint">{{ $project->idea->title }}</a></p>
        @endif
      </div>
      @can('manageTeam', $project)
        <a href="{{ route('projects.team', $project) }}"
          class="px-3 py-1.5 text-sm bg-deep-blue text-white rounded-xl hover:bg-opacity-90">Управлять командой</a>
      @endcan
    </div>


    @if($project->description)
      <p class="text-slate-text mb-6">{{ $project->description }}</p>
    @endif

    <h2 class="text-xl font-semibold text-deep-blue mb-3">Команда</h2>

    <!-- Руководитель проекта -->
    @if($project->teacher)
      <div class="flex items-center space-x-3 p-3 bg-white/50 rounded-xl mb-2">
        @if($project->teacher->avatar)
          <img src="{{ Storage::url($project->teacher->avatar) }}" class="w-8 h-8 rounded-full object-cover">
        @else
          <div class="w-8 h-8 rounded-full bg-mint/20 flex items-center justify-center text-xs font-bold text-mint">
            {{ Str::substr($project->teacher->name, 0, 1) }}
          </div>
        @endif
        <span class="font-medium">{{ $project->teacher->name }}</span>
        <span
          class="text-xs text-slate-light">({{ $project->teacher->role === 'admin' ? 'Администратор' : ($project->teacher->role === 'teacher' ? 'Преподаватель' : 'Студент') }})</span>
      </div>
    @endif

    <!-- Участники (студенты) -->
    @forelse($project->team as $member)
      <div class="flex items-center space-x-3 p-3 bg-white/50 rounded-xl mb-2">
        @if($member->avatar)
          <img src="{{ Storage::url($member->avatar) }}" class="w-8 h-8 rounded-full object-cover">
        @else
          <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-slate-text">
            {{ Str::substr($member->name, 0, 1) }}
          </div>
        @endif
        <span class="font-medium">{{ $member->name }}</span>
        <span
          class="text-xs text-slate-light">({{ $member->role === 'admin' ? 'Администратор' : ($member->role === 'teacher' ? 'Преподаватель' : 'Студент') }})</span>
      </div>
    @empty
      <p class="text-slate-light mb-6">Команда пока не сформирована.</p>
    @endforelse

    <h2 class="text-xl font-semibold text-deep-blue mb-3">Задачи</h2>
    @if($project->tasks->count())
      <div class="space-y-3 mb-4">
        @foreach($project->tasks as $task)
          <div class="flex items-center justify-between p-3 bg-white/50 rounded-xl">
            <div>
              <span class="font-medium">{{ $task->title }}</span>
              <span class="text-xs text-slate-light ml-2">{{ $task->assignee->name ?? 'Не назначен' }}</span>
              @if($task->deadline)
                <span class="text-xs text-slate-light"> / {{ $task->deadline->format('d.m.Y') }}</span>
              @endif
            </div>
            <span class="text-xs px-2 py-1 rounded-full 
                                        @if($task->status === 'done') bg-green-100 text-green-700
                                        @elseif($task->status === 'in_progress') bg-yellow-100 text-yellow-700
                                        @else bg-gray-100 text-gray-600
                                        @endif">
              @if($task->status === 'done') Готово
              @elseif($task->status === 'in_progress') В работе
              @else К выполнению @endif
            </span>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-slate-light mb-4">Задач пока нет.</p>
    @endif

    <div class="flex justify-between items-start mb-6">
      @can('manageTasks', $project)
        <a href="{{ route('projects.tasks', $project) }}"
          class="px-4 py-2 bg-mint text-white font-medium rounded-xl hover:bg-mint/90 transition text-sm">Управлять
          задачами</a>
      @endcan

      @can('update', $project)
        <div>
          <form method="POST" action="{{ route('projects.close', $project) }}">
            @csrf
            @method('PATCH')
            <button type="submit"
              class="px-4 py-2 text-sm font-medium rounded-xl transition
                        {{ $project->status === 'active' ? 'bg-alert-coral text-white hover:bg-red-500' : 'bg-mint text-white hover:bg-mint/90' }}">
              {{ $project->status === 'active' ? 'Завершить проект' : 'Вернуть в работу' }}
            </button>
          </form>
        </div>
      @endcan
    </div>
  </div>
</x-app-layout>