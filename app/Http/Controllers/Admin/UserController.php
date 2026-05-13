<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Список всех пользователей
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->role, function ($q, $role) {
                $q->where('role', $role);
            })
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Форма редактирования роли
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Обновление роли пользователя
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:student,teacher,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users.index')->with('status', 'Роль пользователя обновлена.');
    }
}