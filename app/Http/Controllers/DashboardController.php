<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalIdeas' => Idea::count(),
            'activeProjects' => Project::where('status', 'active')->count(),
            'myTasks' => Task::where('assigned_to', Auth::id())->where('status', '!=', 'done')->count(),
            'latestIdeas' => Idea::latest()->take(5)->get(),
        ]);
    }
}