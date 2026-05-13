<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Список проектов с возможностью закрыть/активировать
     */
    public function index(Request $request)
    {
        $projects = Project::with('teacher', 'idea')
            ->when($request->search, function ($q, $search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Закрытие / активация проекта
     */
    public function close(Project $project)
    {
        $project->update(['status' => $project->status === 'active' ? 'completed' : 'active']);
        $message = $project->status === 'completed' ? 'Проект закрыт.' : 'Проект снова активен.';
        return back()->with('status', $message);
    }
}