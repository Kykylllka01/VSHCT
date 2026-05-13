<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = \App\Models\User::with('skills', 'portfolioItems', 'ideas')->findOrFail($id);
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'group' => 'nullable|string|max:50',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'group'));

        // Синхронизация навыков
        if ($request->has('skills')) {
            $skillIds = Skill::whereIn('name', $request->skills)->pluck('id')->toArray();
            $user->skills()->sync($skillIds);
        }

        return back()->with('success', 'Профиль обновлён.');
    }

    public function destroy(Request $request)
    {
        // Standard delete from breeze
    }
}