<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // заглушка, если нужна главная админ-панели
        return redirect()->route('admin.statistics');
    }

    public function statistics()
    {
        $totalUsers = User::count();
        $students = User::where('role', 'student')->count();
        $teachers = User::where('role', 'teacher')->count();
        $admins = User::where('role', 'admin')->count();

        $totalIdeas = Idea::count();
        $publishedIdeas = Idea::where('status', 'published')->count();
        $approvedIdeas = Idea::where('status', 'approved')->count();
        $rejectedIdeas = Idea::where('status', 'rejected')->count();

        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $completedProjects = Project::where('status', 'completed')->count();

        return view('admin.statistics', compact(
            'totalUsers', 'students', 'teachers', 'admins',
            'totalIdeas', 'publishedIdeas', 'approvedIdeas', 'rejectedIdeas',
            'totalProjects', 'activeProjects', 'completedProjects'
        ));
    }
}