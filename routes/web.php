<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Профиль
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/portfolio/{item}', [ProfileController::class, 'destroyPortfolioItem'])->name('profile.portfolio.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('ideas.show');
    Route::get('/ideas/{idea}/edit', [IdeaController::class, 'edit'])->name('ideas.edit');
    Route::put('/ideas/{idea}', [IdeaController::class, 'update'])->name('ideas.update');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy');
    // Новый маршрут изменения статуса
    Route::patch('/ideas/{idea}/status', [IdeaController::class, 'updateStatus'])->name('ideas.status.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Проекты
    Route::resource('projects', ProjectController::class)->except(['edit', 'update', 'destroy']);
    // Управление командой
    Route::get('projects/{project}/team', [ProjectController::class, 'team'])->name('projects.team');
    Route::post('projects/{project}/team', [ProjectController::class, 'addMember'])->name('projects.team.add');
    Route::delete('projects/{project}/team/{user}', [ProjectController::class, 'removeMember'])->name('projects.team.remove');
    // Задачи
    Route::get('projects/{project}/tasks', [ProjectController::class, 'tasks'])->name('projects.tasks');
    Route::post('projects/{project}/tasks', [ProjectController::class, 'storeTask'])->name('projects.tasks.store');
    Route::patch('projects/{project}/tasks/{task}/status', [ProjectController::class, 'updateTaskStatus'])->name('projects.tasks.status');
    Route::patch('projects/{project}/close', [ProjectController::class, 'close'])->name('projects.close');
});

Route::get('/dashboard', function () {
    // Здесь можно передать данные для админ-панели
    return view('dashboard');
})->middleware(['auth', 'verified', 'can:admin'])->name('dashboard');

require __DIR__ . '/auth.php';