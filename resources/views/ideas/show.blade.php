<x-app-layout>
    <div>
        <a href="{{ route('ideas.index') }}"
            class="text-mint hover:text-deep-blue text-sm font-medium inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            К списку идей
        </a>
    </div>

    <div class="glass-card rounded-2xl p-6 md:p-8 animate-fade-in-up">
        <div class="flex items-center justify-between mb-4">
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                @if($idea->status === 'approved') bg-mint/20 text-mint
                @elseif($idea->status === 'published') bg-blue-100 text-deep-blue
                @elseif($idea->status === 'in_project') bg-purple-100 text-purple-700
                @elseif($idea->status === 'rejected') bg-red-100 text-red-600
                @endif">
                @if($idea->status === 'approved') Одобрено
                @elseif($idea->status === 'published') Опубликовано
                @elseif($idea->status === 'in_project') В проекте
                @elseif($idea->status === 'rejected') Отклонено
                @else Черновик @endif
            </span>
            <span class="text-sm text-slate-light">{{ $idea->created_at->translatedFormat('d M Y, H:i') }}</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-bold text-deep-blue mb-4">{{ $idea->title }}</h1>

        <div class="space-y-6 text-slate-text">
            @if($idea->problem)
                <div>
                    <h3 class="text-lg font-semibold text-deep-blue mb-2">Проблема</h3>
                    <p class="text-sm leading-relaxed">{{ $idea->problem }}</p>
                </div>
            @endif

            @if($idea->solution)
                <div>
                    <h3 class="text-lg font-semibold text-deep-blue mb-2">Предлагаемое решение</h3>
                    <p class="text-sm leading-relaxed">{{ $idea->solution }}</p>
                </div>
            @endif

            @if($idea->expected_result)
                <div>
                    <h3 class="text-lg font-semibold text-deep-blue mb-2">Ожидаемый результат</h3>
                    <p class="text-sm leading-relaxed">{{ $idea->expected_result }}</p>
                </div>
            @endif

            @if($idea->required_resources)
                <div>
                    <h3 class="text-lg font-semibold text-deep-blue mb-2">Ресурсы для реализации</h3>
                    <p class="text-sm leading-relaxed">{{ $idea->required_resources }}</p>
                </div>
            @endif

            @if($idea->technology_stack)
                <div>
                    <h3 class="text-lg font-semibold text-deep-blue mb-2">Стек технологий</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $idea->technology_stack) as $tech)
                            <span class="text-sm bg-gray-100 text-slate-text px-3 py-1 rounded-full">{{ trim($tech) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Автор -->
        <div class="flex justify-between items-end">
            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center">
                <div class="w-10 h-10 rounded-full bg-mint flex items-center justify-center text-white font-semibold">
                    {{ Str::substr($idea->user->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-deep-blue">{{ $idea->user->name }}</p>
                    <p class="text-xs text-slate-light">
                        {{ $idea->user->role === 'teacher' ? 'Преподаватель' : 'Студент' }}
                    </p>
                </div>
            </div>
            <!-- Действия преподавателя -->
            @auth
                @if((Auth::user()->isTeacher() || Auth::user()->isAdmin()) && in_array($idea->status, ['published', 'approved', 'rejected']))
                    <div class=" flex items-center space-x-3">
                        @if($idea->status !== 'approved')
                            <form method="POST" action="{{ route('ideas.status.update', $idea) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                    class="px-4 py-2 bg-mint text-white font-medium rounded-xl hover:bg-mint/90 transition shadow-sm text-sm">
                                    Одобрить
                                </button>
                            </form>
                        @endif
                        @if($idea->status !== 'rejected')
                            <form method="POST" action="{{ route('ideas.status.update', $idea) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                    class="px-4 py-2 bg-alert-coral text-white font-medium rounded-xl hover:bg-red-500 transition shadow-sm text-sm">
                                    Отклонить
                                </button>
                            </form>
                        @endif
                        @if($idea->status === 'approved' && !$idea->project)
                            <a href="{{ route('projects.create', ['idea_id' => $idea->id]) }}"
                                class="px-4 py-2 bg-deep-blue text-white font-medium rounded-xl hover:bg-opacity-90 text-sm">
                                Создать проект на основе идеи
                            </a>
                        @endif
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Комментарии (заглушка) -->
    <div class="glass-card rounded-2xl p-6">
        <h2 class="text-xl font-semibold text-deep-blue mb-4">Комментарии</h2>
        @if($idea->comments->count())
            <div class="space-y-4">
                @foreach($idea->comments as $comment)
                    <div class="flex items-start space-x-3 p-3 bg-white/50 rounded-xl">
                        <div class="w-8 h-8 rounded-full bg-gray-300 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm font-medium text-deep-blue">{{ $comment->user->name }}</p>
                            <p class="text-sm text-slate-text">{{ $comment->body }}</p>
                            <p class="text-xs text-slate-light mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-light">Пока нет комментариев. Будьте первым!</p>
        @endif
    </div>
</x-app-layout>