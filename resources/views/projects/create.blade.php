<x-app-layout>
    <div class="glass-card rounded-2xl p-6 md:p-8">
        <h1 class="text-2xl font-semibold text-deep-blue mb-6">Создать новый проект</h1>
        <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="title" class="block text-sm font-medium text-slate-text">Название проекта *</label>
                <input id="title" name="title" required class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-slate-text">Описание</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint"></textarea>
            </div>
            <div>
                <label for="idea_id" class="block text-sm font-medium text-slate-text">На основе идеи (одобренной)</label>
                <select id="idea_id" name="idea_id" class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
                    <option value="">Без идеи</option>
                    @foreach($approvedIdeas as $idea)
                        <option value="{{ $idea->id }}" {{ $selectedIdea && $selectedIdea->id === $idea->id ? 'selected' : '' }}>
                            {{ $idea->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
                Создать проект
            </button>
        </form>
    </div>
</x-app-layout>