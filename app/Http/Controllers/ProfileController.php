<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\PortfolioItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Просмотр профиля любого пользователя
     */
    public function show(User $user)
{
    $user->load([
        'skills',
        'portfolioItems',
        'ideas' => fn($q) => $q->latest()->take(10),
        'projects',          // проекты, где пользователь участник
        'ledProjects',       // проекты, где пользователь руководитель
    ]);

    // Количество проектов
    $projectCount = $user->projects->count();
    $ledProjectCount = $user->ledProjects->count();
    $totalProjects = $projectCount + $ledProjectCount;

    return view('profile.show', compact('user', 'projectCount', 'ledProjectCount', 'totalProjects'));
}

    /**
     * Форма редактирования собственного профиля
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Обновление профиля
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'group' => 'nullable|string|max:50',
        ]);

        // Обновляем основные поля
        $user->update($request->only(['name', 'email', 'phone', 'group']));

        // Загрузка аватара
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        // Синхронизация навыков
        if ($request->has('skills')) {
            $skillNames = array_map('trim', explode(',', $request->skills));
            $skillIds = [];
            foreach ($skillNames as $name) {
                if (!empty($name)) {
                    $skill = Skill::firstOrCreate(['name' => $name]);
                    $skillIds[] = $skill->id;
                }
            }
            $user->skills()->sync($skillIds);
        }

        // Добавление элемента портфолио (с изображением)
        if ($request->filled('portfolio_title')) {
            $imagePath = null;
            if ($request->hasFile('portfolio_image')) {
                $imagePath = $request->file('portfolio_image')->store('portfolio', 'public');
            }

            PortfolioItem::create([
                'user_id' => $user->id,
                'title' => $request->portfolio_title,
                'description' => $request->portfolio_description,
                'url' => $request->portfolio_url,
                'image' => $imagePath,
            ]);
        }

        return back()->with('status', 'Профиль обновлён.');
    }

    /**
     * Удаление элемента портфолио
     */
    public function destroyPortfolioItem(PortfolioItem $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }
        $item->delete();
        return back()->with('status', 'Элемент удалён.');
    }

}