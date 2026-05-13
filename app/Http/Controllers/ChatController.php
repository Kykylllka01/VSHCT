<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $projects = Project::when(!$user->isAdmin(), function ($query) use ($user) {
            $query->where(function ($q) use ($user) {
                $q->where('teacher_id', $user->id)
                    ->orWhereHas('team', fn($q) => $q->where('user_id', $user->id));
            });
        })->latest()->get();

        return view('chat.list', compact('projects'));
    }

    public function show(Project $project)
    {
        $user = Auth::user();
        $isMember = $project->team->contains($user->id)
            || $project->teacher_id === $user->id
            || $user->isAdmin();
        if (!$isMember)
            abort(403);

        $messages = $project->messages()->with('user')->latest()->take(50)->get()->reverse();
        return view('chat.show', compact('project', 'messages'));
    }

    public function store(Request $request, Project $project)
    {
        // Проверка доступа
        $user = Auth::user();
        $isMember = $project->team->contains($user->id)
            || $project->teacher_id === $user->id
            || $user->isAdmin();
        if (!$isMember) {
            if ($request->expectsJson())
                return response()->json(['error' => 'Forbidden'], 403);
            abort(403);
        }

        $request->validate(['body' => 'required|string|max:1000']);

        $message = $project->messages()->create([
            'user_id' => $user->id,
            'body' => $request->body,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'id' => $message->id,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar ? Storage::url($user->avatar) : null,
                    'initial' => Str::substr($user->name, 0, 1),
                ],
                'body' => $message->body,
                'created_at' => $message->created_at->diffForHumans(),
            ]);
        }

        return back()->with('status', 'Сообщение отправлено.');
    }

    public function fetch(Project $project)
    {
        $lastId = request('last_id', 0);
        $messages = $project->messages()
            ->with('user')
            ->where('id', '>', $lastId)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json(
            $messages->map(fn($m) => [
                'id' => $m->id,
                'user' => [
                    'id' => $m->user->id,
                    'name' => $m->user->name,
                    'avatar' => $m->user->avatar ? Storage::url($m->user->avatar) : null,
                    'initial' => Str::substr($m->user->name, 0, 1),
                ],
                'body' => $m->body,
                'created_at' => $m->created_at->diffForHumans(),
            ])
        );
    }
    public function fetchOlder(Project $project)
    {
        $oldestId = request('oldest_id', 0);

        $messages = $project->messages()
            ->with('user')
            ->where('id', '<', $oldestId)
            ->orderBy('id', 'desc')
            ->take(30)
            ->get()
            ->reverse();

        return response()->json(
            $messages->map(fn($m) => [
                'id' => $m->id,
                'user' => [
                    'id' => $m->user->id,
                    'name' => $m->user->name,
                    'avatar' => $m->user->avatar ? Storage::url($m->user->avatar) : null,
                    'initial' => Str::substr($m->user->name, 0, 1),
                ],
                'body' => $m->body,
                'created_at' => $m->created_at->diffForHumans(),
            ])->values() // <-- ВАЖНО: values() сбрасывает ключи, чтобы получить чистый массив
        );
    }
}