<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Idea;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Notifications\TaskAssigned;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('teacher', 'idea');

        // Поиск по названию
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $projects = $query->latest()->paginate(9)->withQueryString();
        return view('projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Project::class);

        // Подгружаем одобренные идеи, которые ещё не связаны с проектами
        $approvedIdeas = Idea::where('status', 'approved')
            ->whereDoesntHave('project')
            ->get();

        // Если передан параметр idea_id (со страницы идеи), выберем её
        $selectedIdea = null;
        if ($request->has('idea_id')) {
            $selectedIdea = Idea::findOrFail($request->idea_id);
        }

        return view('projects.create', compact('approvedIdeas', 'selectedIdea'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'idea_id' => 'nullable|exists:ideas,id',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'idea_id' => $request->idea_id,
            'teacher_id' => auth()->id(),
            'status' => 'active',
        ]);

        // Если проект создан на основе идеи, меняем статус идеи на 'in_project'
        if ($project->idea) {
            $project->idea->update(['status' => 'in_project']);
        }

        return redirect()->route('projects.show', $project)
            ->with('status', 'Проект успешно создан!');
    }

    public function show(Project $project)
    {
        $project->load('teacher', 'team', 'tasks.assignee', 'idea');
        return view('projects.show', compact('project'));
    }

    // Метод для отображения страницы управления командой
    public function team(Project $project)
    {
        $this->authorize('manageTeam', $project);

        // Все студенты, не состоящие в проекте
        $availableStudents = User::where('role', 'student')
            ->whereDoesntHave('projects', function ($q) use ($project) {
                $q->where('project_id', $project->id);
            })->get();

        return view('projects.team', compact('project', 'availableStudents'));
    }

    // Добавление студента в команду
    public function addMember(Request $request, Project $project)
    {
        $this->authorize('manageTeam', $project);

        $request->validate(['user_id' => 'required|exists:users,id']);

        $project->team()->attach($request->user_id, ['role_in_project' => 'member']);

        return back()->with('status', 'Студент добавлен в команду.');
    }

    // Удаление из команды
    public function removeMember(Project $project, User $user)
    {
        $this->authorize('manageTeam', $project);

        $project->team()->detach($user->id);

        return back()->with('status', 'Студент удалён из команды.');
    }

    // Задачи – отображение и создание
    public function tasks(Project $project)
    {
        $this->authorize('manageTasks', $project);

        $project->load('tasks.assignee', 'team');
        return view('projects.tasks', compact('project'));
    }

    public function storeTask(Request $request, Project $project)
    {
        $this->authorize('manageTasks', $project);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        $task = $project->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'deadline' => $request->deadline,
            'status' => 'todo',
        ]);

        // Отправляем уведомление назначенному пользователю, если он указан
        if ($task->assigned_to) {
            $task->assignee->notify(new TaskAssigned($task));
        }

        return back()->with('status', 'Задача добавлена.');
    }

    // Изменение статуса задачи (например, "в работе", "готово") – для студентов
    public function updateTaskStatus(Request $request, Project $project, Task $task)
    {
        $request->validate(['status' => 'required|in:todo,in_progress,done']);
        $task->update(['status' => $request->status]);
        return back()->with('status', 'Статус задачи обновлён.');
    }

    public function close(Project $project)
    {
        $this->authorize('update', $project); // только руководитель или админ

        $project->update(['status' => $project->status === 'active' ? 'completed' : 'active']);

        $message = $project->status === 'completed' ? 'Проект завершён.' : 'Проект снова активен.';
        return back()->with('status', $message);
    }
}