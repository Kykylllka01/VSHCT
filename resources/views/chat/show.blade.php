<x-app-layout>
  <div class="glass-card rounded-2xl p-6 flex flex-col h-[calc(100vh-10rem)]">
    <!-- Заголовок -->
    <div class="flex items-center space-x-3 mb-4">
      <a href="{{ route('chat.index') }}" class="text-mint hover:text-deep-blue text-sm">
        &larr; К списку чатов
      </a>
      <h1 class="text-xl font-semibold text-deep-blue">Чат команды «{{ $project->title }}»</h1>
    </div>

    <!-- Список сообщений -->
    <div id="chat-messages" class="flex-1 overflow-y-auto space-y-4 mb-4 pr-2">
      @foreach($messages as $message)
        <div
          class="flex items-start space-x-3 {{ $message->user_id === Auth::id() ? 'flex-row-reverse space-x-reverse' : '' }}"
          data-message-id="{{ $message->id }}">
          <div class="flex-shrink-0">
            @if($message->user->avatar)
              <img src="{{ Storage::url($message->user->avatar) }}" class="w-8 h-8 rounded-full">
            @else
              <div
                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-slate-text">
                {{ Str::substr($message->user->name, 0, 1) }}
              </div>
            @endif
          </div>
          <div class="max-w-[70%]">
            <div class="text-xs text-slate-light mb-1">
              {{ $message->user->name }} · {{ $message->created_at->diffForHumans() }}
            </div>
            <div
              class="message-bubble px-4 py-2 rounded-2xl text-sm {{ $message->user_id === Auth::id() ? 'bg-mint text-white' : 'bg-white border border-gray-200 text-slate-text' }}">
              {{ $message->body }}
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Форма отправки -->
    <div class="border-t border-gray-200 pt-4">
      <span id="char-count" class=" ml-2 text-xs text-slate-light mb-1 block text-left">0/1000</span>
      <form id="chat-form" class="flex space-x-2">

        @csrf
        <input type="text" id="chat-input" name="body" placeholder="Введите сообщение..."
          class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-mint/30 focus:border-mint"
          autocomplete="off" required maxlength="1000">

        <button type="submit" class="px-4 py-2 bg-mint text-white font-medium rounded-xl hover:bg-mint/90 transition">
          Отправить
        </button>
      </form>
    </div>
  </div>

  <style>
    #chat-messages .message-bubble {
      word-wrap: break-word;
      overflow-wrap: break-word;
      word-break: break-word;
      hyphens: auto;
      max-width: 100%;
    }
  </style>

  <script>
    window.authUserId = {{ Auth::id() }};
  </script>

  <script>
    function escapeHtml(text) {
      const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      };
      return text.replace(/[&<>"']/g, m => map[m]);
    }
    const chatContainer = document.getElementById('chat-messages');
    if (chatContainer) {
      const projectId = {{ $project->id }};
      let lastMessageId = 0;
      let oldestMessageId = null;
      let isLoadingOlder = false;
      let noMoreOldMessages = false;

      const messageElements = chatContainer.querySelectorAll('[data-message-id]');
      if (messageElements.length > 0) {
        lastMessageId = Math.max(...Array.from(messageElements).map(el => +el.dataset.messageId));
        oldestMessageId = Math.min(...Array.from(messageElements).map(el => +el.dataset.messageId));
      } else {
        noMoreOldMessages = true;
      }

      function appendMessage(msg, prepend = false) {
        if (chatContainer.querySelector(`[data-message-id="${msg.id}"]`)) return;
        const isMine = msg.user.id == window.authUserId;
        const div = document.createElement('div');
        div.dataset.messageId = msg.id;
        div.className = `flex items-start space-x-3 ${isMine ? 'flex-row-reverse space-x-reverse' : ''}`;
        div.innerHTML = `
        <div class="flex-shrink-0">
          ${msg.user.avatar
            ? `<img src="${msg.user.avatar}" class="w-8 h-8 rounded-full">`
            : `<div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-slate-text">${msg.user.initial}</div>`
          }
        </div>
        <div class="flex flex-col ${isMine ? 'items-end' : ''} max-w-[70%] min-w-0">
          <div class="text-xs text-slate-light mb-1">${msg.user.name} · ${msg.created_at}</div>
          <div class="message-bubble px-4 py-2 rounded-2xl text-sm ${isMine ? 'bg-mint text-white' : 'bg-white border border-gray-200 text-slate-text'}">
            ${escapeHtml(msg.body)}
          </div>
        </div>
      `;

        if (prepend) {
          chatContainer.insertBefore(div, chatContainer.firstChild);
        } else {
          chatContainer.appendChild(div);
          chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        if (msg.id > lastMessageId) lastMessageId = msg.id;
        if (msg.id < oldestMessageId || oldestMessageId === null) oldestMessageId = msg.id;
      }

      chatContainer.scrollTop = chatContainer.scrollHeight;

      chatContainer.addEventListener('scroll', async () => {
        const scrollTop = chatContainer.scrollTop;
        if (scrollTop < 50 && !isLoadingOlder && !noMoreOldMessages && oldestMessageId !== null) {
          isLoadingOlder = true;
          try {
            const res = await fetch(`/projects/${projectId}/chat/older?oldest_id=${oldestMessageId}`);
            if (res.ok) {
              const data = await res.json();
              if (Array.isArray(data)) {
                if (data.length === 0) {
                  noMoreOldMessages = true;
                } else {
                  const prevScrollHeight = chatContainer.scrollHeight;
                  data.forEach(msg => appendMessage(msg, true));
                  const newScrollHeight = chatContainer.scrollHeight;
                  chatContainer.scrollTop = newScrollHeight - prevScrollHeight;
                }
              } else {
                console.error('Ответ не является массивом:', data);
                noMoreOldMessages = true;
              }
            } else {
              noMoreOldMessages = true;
            }
          } catch (e) {
            console.error('Failed to load older messages:', e);
          } finally {
            isLoadingOlder = false;
          }
        }
      });

      setInterval(async () => {
        try {
          const res = await fetch(`/projects/${projectId}/chat/fetch?last_id=${lastMessageId}`);
          if (res.ok) {
            const newMessages = await res.json();
            newMessages.forEach(msg => appendMessage(msg, false));
          }
        } catch (e) {
          console.error('Polling error:', e);
        }
      }, 2000);

      const form = document.getElementById('chat-form');
      const input = document.getElementById('chat-input');
      const submitBtn = form.querySelector('button[type="submit"]');

      // Счётчик символов
      const charCounter = document.getElementById('char-count');
      if (charCounter) {
        input.addEventListener('input', () => {
          const len = input.value.length;
          charCounter.textContent = `${len}/1000`;
          if (len >= 1000) {
            charCounter.classList.add('text-red-500');
          } else {
            charCounter.classList.remove('text-red-500');
          }
        });
      }

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const body = input.value.trim();
        if (!body) return;

        submitBtn.disabled = true;
        submitBtn.textContent = '...';

        try {
          const res = await fetch(`/projects/${projectId}/chat`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json',
            },
            body: JSON.stringify({ body }),
          });

          if (res.ok) {
            const msg = await res.json();
            appendMessage(msg);
            input.value = '';
            if (charCounter) {
              charCounter.textContent = '0/1000';
              charCounter.classList.remove('text-red-500');
            }
          } else {
            let errorText = 'Неизвестная ошибка';
            try {
              const errorData = await res.json();
              errorText = errorData.message || errorData.error || JSON.stringify(errorData);
            } catch {
              errorText = `HTTP ${res.status}`;
            }
            alert('Ошибка отправки: ' + errorText);
          }
        } catch (err) {
          console.error('Fetch error:', err);
          alert('Сетевая ошибка. Проверьте подключение.');
        } finally {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Отправить';
        }
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          form.dispatchEvent(new Event('submit'));
        }
      });
    }
  </script>
</x-app-layout>