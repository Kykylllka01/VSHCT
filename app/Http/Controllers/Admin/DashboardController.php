<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idea;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Главная страница админ-панели (заглушка)
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Статистика по проектам и участникам
     */
    public function statistics()
    {
        $totalUsers = User::count();
        $totalIdeas = Idea::count();
        $totalProjects = Project::count();

        return view('admin.statistics', compact('totalUsers', 'totalIdeas', 'totalProjects'));
    }
}