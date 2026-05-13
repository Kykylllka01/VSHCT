@if ($paginator->hasPages())
  <nav role="navigation" aria-label="Пагинация" class="mt-8">
    <div class="glass-card rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
      <!-- Информация о количестве -->
      <p class="text-sm text-slate-light">
        Показано с <span class="font-medium text-deep-blue">{{ $paginator->firstItem() }}</span>
        по <span class="font-medium text-deep-blue">{{ $paginator->lastItem() }}</span>
        из <span class="font-medium text-deep-blue">{{ $paginator->total() }}</span> результатов
      </p>

      <!-- Кнопки страниц -->
      <div class="flex items-center space-x-1">
        {{-- Кнопка "Назад" --}}
        @if ($paginator->onFirstPage())
          <span class="px-3 py-2 text-sm text-slate-light bg-gray-100 rounded-xl cursor-not-allowed opacity-50">
            Назад
          </span>
        @else
          <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
            class="px-3 py-2 text-sm font-medium text-deep-blue bg-white hover:bg-mint/10 rounded-xl transition shadow-sm">
            Назад
          </a>
        @endif

        {{-- Номера страниц --}}
        @foreach ($elements as $element)
          @if (is_string($element))
            <span class="px-3 py-2 text-sm text-slate-light">{{ $element }}</span>
          @endif

          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <span class="px-3 py-2 text-sm font-semibold text-white bg-mint rounded-xl shadow-sm">
                  {{ $page }}
                </span>
              @else
                <a href="{{ $url }}"
                  class="px-3 py-2 text-sm font-medium text-deep-blue bg-white hover:bg-mint/10 rounded-xl transition shadow-sm">
                  {{ $page }}
                </a>
              @endif
            @endforeach
          @endif
        @endforeach

        {{-- Кнопка "Вперёд" --}}
        @if ($paginator->hasMorePages())
          <a href="{{ $paginator->nextPageUrl() }}" rel="next"
            class="px-3 py-2 text-sm font-medium text-deep-blue bg-white hover:bg-mint/10 rounded-xl transition shadow-sm">
            Вперёд
          </a>
        @else
          <span class="px-3 py-2 text-sm text-slate-light bg-gray-100 rounded-xl cursor-not-allowed opacity-50">
            Вперёд
          </span>
        @endif
      </div>
    </div>
  </nav>
@endif