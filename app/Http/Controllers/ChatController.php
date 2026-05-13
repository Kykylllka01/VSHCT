<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Project $project)
    {
        $messages = $project->messages()->with('user')->latest()->take(50)->get()->reverse();
        return view('chat.index', compact('project', 'messages'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate(['body' => 'required|string']);
        $project->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);
        return back()->with('success', 'Сообщение отправлено.');
    }
}