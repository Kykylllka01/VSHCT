<x-app-layout>
    <div class="space-y-8 animate-fade-in-up">
        <!-- Заголовок профиля с аватаром -->
        <div class="flex items-center space-x-4">
            @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" class="w-16 h-16 rounded-full object-cover">
            @else
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-deep-blue to-mint flex items-center justify-center text-white text-2xl font-bold">
                    {{ Str::substr($user->name, 0, 1) }}
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-deep-blue">{{ $user->name }}</h1>
                <p class="text-slate-light">{{ $user->role === 'teacher' ? 'Преподаватель' : 'Студент' }}</p>
            </div>
            @if(Auth::id() === $user->id)
                <a href="{{ route('profile.edit') }}" class="ml-auto px-4 py-2 text-sm bg-mint text-white rounded-xl hover:bg-mint/90 transition">
                    Редактировать
                </a>
            @endif
        </div>

        <!-- Общая информация -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-deep-blue mb-4">Общая информация</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-slate-light block">Email</span>
                    <span class="text-slate-text font-medium">{{ $user->email }}</span>
                </div>
                @if($user->phone)
                <div>
                    <span class="text-slate-light block">Телефон</span>
                    <span class="text-slate-text font-medium">{{ $user->phone }}</span>
                </div>
                @endif
                @if($user->group)
                <div>
                    <span class="text-slate-light block">Учебная группа</span>
                    <span class="text-slate-text font-medium">{{ $user->group }}</span>
                </div>
                @endif
                <div>
                    <span class="text-slate-light block">Дата регистрации</span>
                    <span class="text-slate-text font-medium">{{ $user->created_at->format('d.m.Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Компетенции -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-deep-blue mb-4">Компетенции</h2>
            @if($user->skills->count())
                <div class="flex flex-wrap gap-2">
                    @foreach($user->skills as $skill)
                        <span class="px-3 py-1 bg-gray-100 text-slate-text rounded-full text-sm">{{ $skill->name }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-slate-light text-sm">Компетенции не указаны.</p>
            @endif
        </div>

        <!-- Идеи -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-deep-blue mb-4">Идеи</h2>
            @if($user->ideas->count())
                <div class="space-y-3">
                    @foreach($user->ideas as $idea)
                        <a href="{{ route('ideas.show', $idea) }}" class="block p-3 bg-white/50 rounded-xl hover:bg-white/80 transition">
                            <span class="font-medium text-deep-blue">{{ $idea->title }}</span>
                            <span class="text-xs text-slate-light ml-2">{{ $idea->status === 'published' ? 'Опубликовано' : ($idea->status === 'approved' ? 'Одобрено' : $idea->status) }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-slate-light text-sm">Пока нет идей.</p>
            @endif
        </div>

        <!-- Портфолио -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-deep-blue mb-4">Личное портфолио</h2>
            @if($user->portfolioItems->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($user->portfolioItems as $item)
                        <div class="p-4 bg-white/50 rounded-xl">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" class="w-full h-32 object-cover rounded-lg mb-2">
                            @endif
                            <h3 class="font-semibold text-deep-blue">{{ $item->title }}</h3>
                            @if($item->description)
                                <p class="text-sm text-slate-text mt-1">{{ $item->description }}</p>
                            @endif
                            @if($item->url)
                                <a href="{{ $item->url }}" target="_blank" class="text-sm text-mint mt-2 inline-block">Ссылка</a>
                            @endif
                            @if(Auth::id() === $user->id)
                                <form method="POST" action="{{ route('profile.portfolio.destroy', $item) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Удалить</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-slate-light text-sm">Портфолио пока пустое.</p>
            @endif
        </div>
    </div>
</x-app-layout>