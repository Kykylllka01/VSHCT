<x-app-layout>
  <div class="glass-card rounded-2xl p-6 md:p-8">
    <h1 class="text-2xl font-semibold text-deep-blue mb-6">Редактировать профиль</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PATCH')

      <!-- Имя -->
      <div>
        <label for="name" class="block text-sm font-medium text-slate-text">ФИО</label>
        <input id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-slate-text">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
      </div>

      <!-- Телефон -->
      <div>
        <label for="phone" class="block text-sm font-medium text-slate-text">Телефон</label>
        <input id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
      </div>

      <!-- Группа -->
      <div>
        <label for="group" class="block text-sm font-medium text-slate-text">Учебная группа</label>
        <input id="group" name="group" value="{{ old('group', Auth::user()->group) }}"
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
      </div>
      <div>
        <label for="avatar" class="block text-sm font-medium text-slate-text">Аватар</label>
        <input id="avatar" name="avatar" type="file" accept="image/*"
          class="mt-1 block w-full text-sm text-slate-text file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-mint/10 file:text-mint hover:file:bg-mint/20">
        @if(Auth::user()->avatar)
          <img src="{{ Storage::url(Auth::user()->avatar) }}" class="mt-2 w-16 h-16 rounded-full object-cover">
        @endif
      </div>
      <!-- Компетенции -->
      <div>
        <label for="skills" class="block text-sm font-medium text-slate-text">Компетенции (через запятую)</label>
        <input id="skills" name="skills" value="{{ old('skills', Auth::user()->skills->pluck('name')->implode(', ')) }}"
          class="mt-1 block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
      </div>

      <!-- Добавить элемент портфолио -->
      <div class="border-t border-gray-200 pt-6">
        <h2 class="text-lg font-medium text-deep-blue mb-4">Добавить в портфолио</h2>
        <div class="space-y-4">
          <input name="portfolio_title" placeholder="Название проекта/сертификата"
            class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
          <textarea name="portfolio_description" rows="2" placeholder="Краткое описание"
            class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint"></textarea>
          <input name="portfolio_url" placeholder="Ссылка (если есть)"
            class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint">
          <input type="file" name="portfolio_image" accept="image/*"
            class="block w-full text-sm text-slate-text file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-mint/10 file:text-mint hover:file:bg-mint/20">
        </div>
      </div>

      <button type="submit"
        class="px-6 py-2.5 bg-mint text-white font-semibold rounded-xl hover:bg-mint/90 transition shadow-sm">
        Сохранить
      </button>
    </form>
  </div>
</x-app-layout>