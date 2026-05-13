<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\UserController;
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
    Route::post('/ideas/{idea}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
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
    // Пометить все уведомления прочитанными
    Route::post('/notifications/mark-all-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

    // Список чатов пользователя
    Route::get('chats', [ChatController::class, 'index'])->name('chat.index');
    // Чат конкретного проекта
    Route::get('chats/{project}', [ChatController::class, 'show'])->name('chat.show');
    // Отправка сообщения и получение новых (остались привязаны к проекту)
    Route::post('projects/{project}/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('projects/{project}/chat/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');

    Route::get('projects/{project}/chat/older', [ChatController::class, 'fetchOlder'])->name('chat.older');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:admin'])->group(function () {
    // Пользователи
    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.updateRole');

    // Проекты
    Route::get('projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('projects.index');
    Route::patch('projects/{project}/close', [\App\Http\Controllers\Admin\ProjectController::class, 'close'])->name('projects.close');

    // Статистика
    Route::get('statistics', [\App\Http\Controllers\Admin\DashboardController::class, 'statistics'])->name('statistics');
});

require __DIR__ . '/auth.php';