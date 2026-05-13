<x-app-layout>
  <div class="animate-fade-in-up">
    <a href="{{ route('ideas.index') }}"
      class="text-mint hover:text-deep-blue text-sm font-medium inline-flex items-center">
      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      К списку идей
    </a>
  </div>

  <div class="glass-card rounded-2xl p-6 md:p-8 animate-fade-in-up">
    <h1 class="text-2xl font-semibold text-deep-blue mb-6">Подать новую идею</h1>

    <form method="POST" action="{{ route('ideas.store') }}" class="space-y-6">
      @csrf

      <!-- Название -->
      <div>
        <label for="title" class="block text-sm font-medium text-slate-text">Название идеи *</label>
        <input id="title" type="text" name="title" value="{{ old('title') }}" required
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
        <x-input-error :messages="$errors->get('title')" class="mt-1" />
      </div>

      <!-- Проблема -->
      <div>
        <label for="problem" class="block text-sm font-medium text-slate-text">Описание проблемы</label>
        <textarea id="problem" name="problem" rows="3"
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">{{ old('problem') }}</textarea>
        <x-input-error :messages="$errors->get('problem')" class="mt-1" />
      </div>

      <!-- Решение -->
      <div>
        <label for="solution" class="block text-sm font-medium text-slate-text">Предлагаемое решение</label>
        <textarea id="solution" name="solution" rows="3"
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">{{ old('solution') }}</textarea>
        <x-input-error :messages="$errors->get('solution')" class="mt-1" />
      </div>

      <!-- Ожидаемый результат -->
      <div>
        <label for="expected_result" class="block text-sm font-medium text-slate-text">Ожидаемый результат</label>
        <textarea id="expected_result" name="expected_result" rows="2"
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">{{ old('expected_result') }}</textarea>
        <x-input-error :messages="$errors->get('expected_result')" class="mt-1" />
      </div>

      <!-- Ресурсы -->
      <div>
        <label for="required_resources" class="block text-sm font-medium text-slate-text">Необходимые ресурсы</label>
        <textarea id="required_resources" name="required_resources" rows="2"
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">{{ old('required_resources') }}</textarea>
        <x-input-error :messages="$errors->get('required_resources')" class="mt-1" />
      </div>

      <!-- Стек технологий -->
      <div>
        <label for="technology_stack" class="block text-sm font-medium text-slate-text">Стек технологий (через
          запятую)</label>
        <input id="technology_stack" type="text" name="technology_stack" value="{{ old('technology_stack') }}"
          placeholder="Laravel, Vue.js, MySQL..."
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint transition duration-200">
        <x-input-error :messages="$errors->get('technology_stack')" class="mt-1" />
      </div>

      <!-- Кнопка -->
      <div class="flex items-center justify-end space-x-3">
        <a href="{{ route('ideas.index') }}" class="text-sm text-slate-light hover:text-deep-blue transition">Отмена</a>
        <button type="submit"
          class="px-6 py-2.5 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
          Отправить на рассмотрение
        </button>
      </div>
    </form>
  </div>
</x-app-layout>