<x-admin-layout>
    <div class="space-y-8">
        <h1 class="text-3xl font-bold text-deep-blue">Статистика</h1>

        <!-- Пользователи -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-deep-blue mb-4">Пользователи</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-deep-blue">{{ $totalUsers }}</p>
                    <p class="text-sm text-slate-light">Всего</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-deep-blue">{{ $students }}</p>
                    <p class="text-sm text-slate-light">Студентов</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-deep-blue">{{ $teachers }}</p>
                    <p class="text-sm text-slate-light">Преподавателей</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-deep-blue">{{ $admins }}</p>
                    <p class="text-sm text-slate-light">Администраторов</p>
                </div>
            </div>
        </div>

        <!-- Идеи -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-deep-blue mb-4">Идеи</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-deep-blue">{{ $totalIdeas }}</p>
                    <p class="text-sm text-slate-light">Всего</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-blue-600">{{ $publishedIdeas }}</p>
                    <p class="text-sm text-slate-light">Опубликовано</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-mint">{{ $approvedIdeas }}</p>
                    <p class="text-sm text-slate-light">Одобрено</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-red-500">{{ $rejectedIdeas }}</p>
                    <p class="text-sm text-slate-light">Отклонено</p>
                </div>
            </div>
        </div>

        <!-- Проекты -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-deep-blue mb-4">Проекты</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-deep-blue">{{ $totalProjects }}</p>
                    <p class="text-sm text-slate-light">Всего</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-mint">{{ $activeProjects }}</p>
                    <p class="text-sm text-slate-light">Активных</p>
                </div>
                <div class="text-center p-3 bg-white/50 rounded-xl">
                    <p class="text-2xl font-bold text-gray-500">{{ $completedProjects }}</p>
                    <p class="text-sm text-slate-light">Завершённых</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>