<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;

class IdeaController extends Controller
{
    /**
     * Список всех идей
     */
    public function index()
    {
        $ideas = Idea::with('user')->latest()->paginate(10);
        return view('admin.ideas.index', compact('ideas'));
    }

    /**
     * Удалить идею
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();
        return back()->with('status', 'Идея удалена.');
    }
}