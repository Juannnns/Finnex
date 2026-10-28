@extends('layouts.app')

@section('title', 'FIN-BOT')
@section('page-title', 'FIN-BOT')
@section('page-subtitle', 'Asistente financiero inteligente')

@push('styles')
<style>
.finbot-shell {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: var(--space-5);
    height: calc(100vh - var(--topbar-height) - 48px);
    min-height: 500px;
}

@media (max-width: 900px) {
    .finbot-shell { grid-template-columns: 1fr; }
    .finbot-sidebar { display: none; }
}
</style>
@endpush

@section('content')

<div class="finbot-shell">

    {{-- Left Panel --}}
    <div class="finbot-sidebar card" style="display:flex;flex-direction:column;overflow:hidden;">

        {{-- Bot Avatar --}}
        <div style="text-align:center;padding:var(--space-6) var(--space-4) var(--space-5);border-bottom:1px solid var(--border-subtle);">
            <div style="width:80px;height:80px;margin:0 auto var(--space-3);background:var(--gradient-brand);border-radius:var(--radius-full);display:flex;align-items:center;justify-content:center;box-shadow:0 0 30px rgba(124,58,237,0.5);position:relative;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    <circle cx="12" cy="17" r="1" fill="white"/>
                </svg>
                <div style="position:absolute;bottom:2px;right:2px;width:14px;height:14px;background:var(--color-success);border-radius:50%;border:2px solid var(--bg-surface);"></div>
            </div>
            <div style="font-size:var(--font-size-lg);font-weight:800;color:var(--text-primary);">FIN-BOT</div>
            <div style="font-size:var(--font-size-xs);color:var(--color-success);margin-top:2px;">● En línea</div>
            <p style="font-size:var(--font-size-xs);color:var(--text-muted);margin-top:var(--space-3);line-height:1.5;">
                Tu asistente financiero personal. Pregúntame sobre tus gastos, metas y estrategias de ahorro.
            </p>
        </div>

        {{-- Capabilities --}}
        <div style="padding:var(--space-4);flex:1;overflow-y:auto;">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:var(--space-3);">Puedo ayudarte con</div>
            @php
                $capabilities = [
                    ['icon'=>'💰','text'=>'Análisis de gastos e ingresos'],
                    ['icon'=>'🎯','text'=>'Planificación de metas'],
                    ['icon'=>'📊','text'=>'Presupuesto mensual'],
                    ['icon'=>'💡','text'=>'Estrategias de ahorro'],
                    ['icon'=>'🚨','text'=>'Alertas financieras'],
                    ['icon'=>'📈','text'=>'Tendencias y proyecciones'],
                ];
            @endphp
            @foreach($capabilities as $cap)
            <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border-subtle);">
                <span style="font-size:16px;">{{ $cap['icon'] }}</span>
                <span style="font-size:12px;color:var(--text-secondary);">{{ $cap['text'] }}</span>
            </div>
            @endforeach
        </div>

        {{-- AI Note --}}
        <div style="padding:var(--space-4);border-top:1px solid var(--border-subtle);">
            <div style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);border-radius:var(--radius-md);padding:10px 12px;font-size:11px;color:var(--color-primary-light);line-height:1.5;">
                🤖 Actualmente en modo demo. Próximamente conectado a IA avanzada.
            </div>
        </div>

    </div>

    {{-- Chat Area --}}
    <div class="card" style="display:flex;flex-direction:column;overflow:hidden;padding:0;">

        {{-- Chat Header --}}
        <div style="padding:var(--space-4) var(--space-5);border-bottom:1px solid var(--border-subtle);display:flex;align-items:center;gap:var(--space-3);">
            <div style="width:40px;height:40px;background:var(--gradient-brand);border-radius:var(--radius-full);display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <div>
                <div style="font-weight:700;color:var(--text-primary);font-size:var(--font-size-base);">FIN-BOT</div>
                <div style="font-size:11px;color:var(--color-success);">● En línea · Responde en segundos</div>
            </div>
            <div style="margin-left:auto;display:flex;gap:8px;">
                <button class="btn btn-ghost btn-sm" onclick="clearChat()" title="Nueva conversación">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/>
                    </svg>
                    Nueva
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div class="chat-messages" id="chat-messages">

            {{-- Initial messages --}}
            @foreach($initialMessages as $msg)
            <div class="chat-bubble-wrap {{ $msg['role'] }}">
                @if($msg['role'] === 'bot')
                <div class="chat-avatar bot">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div>
                    <div class="chat-bubble bot">{!! nl2br(e($msg['text'])) !!}</div>
                    <div class="chat-time">{{ $msg['time'] }}</div>
                </div>
                @endif
            </div>
            @endforeach

        </div>

        {{-- Input Area --}}
        <div class="chat-input-area">
            {{-- Quick Chips --}}
            <div class="chat-suggestions">
                <button class="chat-suggestion-chip" data-text="Agrega gasto de 20000 en comida">🍔 Agregar gasto</button>
                <button class="chat-suggestion-chip" data-text="¿Cuánto he gastado este mes?">📊 Total gastado</button>
                <button class="chat-suggestion-chip" data-text="Reiniciar mis gastos">♻️ Reiniciar gastos</button>
                <button class="chat-suggestion-chip" data-text="¿Cómo va mi meta de vacaciones?">🎯 Ver metas</button>
                <button class="chat-suggestion-chip" data-text="Dame un presupuesto para este mes">📋 Crear presupuesto</button>
            </div>

            {{-- Input Row --}}
            <form class="chat-input-row" id="finbot-form">
                @csrf
                <textarea
                    id="finbot-input"
                    class="form-input"
                    placeholder="Escribe tu pregunta financiera... (Enter para enviar)"
                    rows="1"
                    aria-label="Mensaje para FIN-BOT"
                ></textarea>
                <button type="submit" class="btn btn-primary btn-icon" id="finbot-send-btn" aria-label="Enviar mensaje" style="flex-shrink:0;width:46px;height:46px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                </button>
            </form>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/finbot.js') }}"></script>
<script>
function clearChat() {
    const messages = document.getElementById('chat-messages');
    if (messages) {
        messages.innerHTML = '';
        // Add welcome back message
        setTimeout(() => {
            if (window.sendMessage) return;
            const wrap = document.createElement('div');
            wrap.className = 'chat-bubble-wrap bot animate-fade-up';
            wrap.innerHTML = `
                <div class="chat-avatar bot">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div>
                    <div class="chat-bubble bot">¡Conversación reiniciada! ¿En qué puedo ayudarte? 🤖</div>
                    <div class="chat-time">${new Date().toLocaleTimeString('es-CL',{hour:'2-digit',minute:'2-digit'})}</div>
                </div>
            `;
            messages.appendChild(wrap);
        }, 100);
    }
}

// Override sendMessage to use AJAX
window.sendMessage = function(text) {
    const messages = document.getElementById('chat-messages');
    if (!messages) return;

    // Append user bubble
    const now = new Date().toLocaleTimeString('es-CL',{hour:'2-digit',minute:'2-digit'});
    const userWrap = document.createElement('div');
    userWrap.className = 'chat-bubble-wrap user animate-fade-up';
    userWrap.innerHTML = `
        <div class="chat-avatar user">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="chat-bubble user">${text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')}</div>
            <div class="chat-time" style="text-align:right">${now}</div>
        </div>
    `;
    messages.appendChild(userWrap);
    messages.scrollTop = messages.scrollHeight;

    // Show typing
    const typingId = 'typing-' + Date.now();
    const typingWrap = document.createElement('div');
    typingWrap.id = typingId;
    typingWrap.className = 'chat-bubble-wrap bot';
    typingWrap.innerHTML = `
        <div class="chat-avatar bot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
        <div class="typing-indicator"><span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span></div>
    `;
    messages.appendChild(typingWrap);
    messages.scrollTop = messages.scrollHeight;

    // AJAX call
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    fetch('{{ route("finbot.message") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ message: text })
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById(typingId)?.remove();
        if (data.success) {
            const botWrap = document.createElement('div');
            botWrap.className = 'chat-bubble-wrap bot animate-fade-up';
            botWrap.innerHTML = `
                <div class="chat-avatar bot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                <div>
                    <div class="chat-bubble bot">${data.response.replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>').replace(/\n/g,'<br>')}</div>
                    <div class="chat-time">${data.time}</div>
                </div>
            `;
            messages.appendChild(botWrap);
            messages.scrollTop = messages.scrollHeight;
        }
    })
    .catch(() => {
        document.getElementById(typingId)?.remove();
        // Fallback to local response
        const local = typeof getBotResponse === 'function' ? getBotResponse(text) : 'Lo siento, hubo un problema. Intenta de nuevo.';
        const botWrap = document.createElement('div');
        botWrap.className = 'chat-bubble-wrap bot animate-fade-up';
        botWrap.innerHTML = `
            <div class="chat-avatar bot"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
            <div><div class="chat-bubble bot">${local.replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>').replace(/\n/g,'<br>')}</div></div>
        `;
        messages.appendChild(botWrap);
        messages.scrollTop = messages.scrollHeight;
    });
};
</script>
@endpush
