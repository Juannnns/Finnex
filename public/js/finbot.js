/**
 * FINNEX — FIN-BOT Chat JavaScript
 * finbot.js
 */

document.addEventListener('DOMContentLoaded', () => {
    initFinBot();
});

function initFinBot() {
    const form      = document.getElementById('finbot-form');
    const input     = document.getElementById('finbot-input');
    const messages  = document.getElementById('chat-messages');
    const sendBtn   = document.getElementById('finbot-send-btn');

    if (!form || !input || !messages) return;

    // Send on form submit
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;
        sendMessage(text);
        input.value = '';
        input.style.height = 'auto';
    });

    // Auto-resize textarea
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    });

    // Enter to send (Shift+Enter for newline)
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });

    // Quick suggestion chips
    document.querySelectorAll('.chat-suggestion-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            const text = chip.dataset.text || chip.textContent.trim();
            input.value = text;
            input.focus();
        });
    });

    // Scroll to bottom initially
    scrollToBottom();
}

function sendMessage(text) {
    const messages = document.getElementById('chat-messages');
    if (!messages) return;

    // Append user message
    appendMessage('user', text);
    scrollToBottom();

    // Show typing indicator
    const typingId = showTyping();

    // Simulate API delay
    const delay = 800 + Math.random() * 1200;

    setTimeout(() => {
        removeTyping(typingId);
        const response = getBotResponse(text);
        appendMessage('bot', response);
        scrollToBottom();
    }, delay);
}

function appendMessage(role, text) {
    const messages = document.getElementById('chat-messages');
    const now = new Date().toLocaleTimeString('es-CL', { hour: '2-digit', minute: '2-digit' });

    const isUser = role === 'user';
    const wrap = document.createElement('div');
    wrap.className = `chat-bubble-wrap ${role} animate-fade-up`;

    if (isUser) {
        wrap.innerHTML = `
            <div class="chat-avatar user">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <div class="chat-bubble user">${escapeHtml(text)}</div>
                <div class="chat-time" style="text-align:right">${now}</div>
            </div>
        `;
    } else {
        wrap.innerHTML = `
            <div class="chat-avatar bot">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/><circle cx="12" cy="17" r="1" fill="currentColor"/></svg>
            </div>
            <div>
                <div class="chat-bubble bot">${formatBotResponse(text)}</div>
                <div class="chat-time">${now}</div>
            </div>
        `;
    }

    messages.appendChild(wrap);
}

function showTyping() {
    const messages = document.getElementById('chat-messages');
    const id = 'typing-' + Date.now();

    const wrap = document.createElement('div');
    wrap.className = 'chat-bubble-wrap bot';
    wrap.id = id;
    wrap.innerHTML = `
        <div class="chat-avatar bot">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div class="typing-indicator">
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
        </div>
    `;

    messages.appendChild(wrap);
    scrollToBottom();
    return id;
}

function removeTyping(id) {
    const el = document.getElementById(id);
    if (el) el.remove();
}

function scrollToBottom() {
    const messages = document.getElementById('chat-messages');
    if (messages) {
        messages.scrollTop = messages.scrollHeight;
    }
}

function escapeHtml(text) {
    return text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function formatBotResponse(text) {
    // Allow basic formatting: bold with **text**, newlines as <br>
    return text
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\n/g, '<br>');
}

/* ================================================
   SIMULATED RESPONSES
   ================================================ */
function getBotResponse(userInput) {
    const input = userInput.toLowerCase();

    // Keyword matching
    if (contains(input, ['ahorrar', 'ahorro', 'guardar'])) {
        return responses.ahorro[rand(responses.ahorro.length)];
    }
    if (contains(input, ['gasto', 'gastos', 'gastar', 'gaste'])) {
        return responses.gastos[rand(responses.gastos.length)];
    }
    if (contains(input, ['ingreso', 'sueldo', 'salario', 'ganancia'])) {
        return responses.ingresos[rand(responses.ingresos.length)];
    }
    if (contains(input, ['meta', 'objetivo', 'viaje', 'auto', 'casa'])) {
        return responses.metas[rand(responses.metas.length)];
    }
    if (contains(input, ['deuda', 'crédito', 'credito', 'préstamo', 'prestamo'])) {
        return responses.deudas[rand(responses.deudas.length)];
    }
    if (contains(input, ['inversión', 'inversion', 'invertir', 'acciones', 'fondos'])) {
        return responses.inversiones[rand(responses.inversiones.length)];
    }
    if (contains(input, ['emergencia', 'fondo', 'imprevisto'])) {
        return responses.emergencia[rand(responses.emergencia.length)];
    }
    if (contains(input, ['salud financiera', 'score', 'puntaje', 'estado'])) {
        return responses.salud[rand(responses.salud.length)];
    }
    if (contains(input, ['hola', 'buenas', 'buenos', 'saludos'])) {
        return responses.saludo[rand(responses.saludo.length)];
    }
    if (contains(input, ['gracias', 'muchas gracias', 'perfecto', 'excelente'])) {
        return responses.agradecimiento[rand(responses.agradecimiento.length)];
    }
    if (contains(input, ['presupuesto', 'budget', 'planificar', 'plan'])) {
        return responses.presupuesto[rand(responses.presupuesto.length)];
    }

    return responses.default[rand(responses.default.length)];
}

function contains(text, keywords) {
    return keywords.some(kw => text.includes(kw));
}

function rand(max) {
    return Math.floor(Math.random() * max);
}

const responses = {
    saludo: [
        "¡Hola! Soy **FIN-BOT**, tu asistente financiero personal 🤖\n\nEstoy aquí para ayudarte a organizar tus finanzas, analizar tus gastos y guiarte hacia tus metas. ¿En qué puedo ayudarte hoy?",
        "¡Bienvenido de vuelta! 👋\n\nTu **salud financiera** se encuentra en **82/100** — ¡muy bien! ¿Quieres revisar algún aspecto de tus finanzas?",
    ],
    ahorro: [
        "Según tu situación actual, podrías intentar ahorrar **$350.000** este mes. Esto te permitiría avanzar aproximadamente un **12%** hacia tu meta de vacaciones.\n\n💡 Tip: Reducir el gasto en entretenimiento un 20% te daría $30.000 adicionales.",
        "Basándome en tus ingresos de **$3.200.000** y gastos de **$1.890.000**, tienes un margen disponible de $1.310.000.\n\nTe recomiendo destinar el **30%** de ese margen al ahorro, es decir, aproximadamente **$393.000** mensuales.",
        "La regla **50/30/20** sugiere:\n• **50%** para necesidades: $1.600.000\n• **30%** para deseos: $960.000\n• **20%** para ahorro: **$640.000**\n\nActualmente estás ahorrando $360.000. ¡Con algunos ajustes podrías casi duplicarlo!",
    ],
    gastos: [
        "Este mes tus gastos totales son **$1.890.000**. El mayor rubro es **Vivienda** con $580.000 (31% del total).\n\n🔍 Detecté que tus gastos en entretenimiento aumentaron un 15% respecto al mes pasado. ¿Quieres ver el detalle?",
        "Tus principales categorías de gasto son:\n• 🏠 Vivienda: **$580.000** (31%)\n• 🍔 Alimentación: **$420.000** (22%)\n• 🚗 Transporte: **$230.000** (12%)\n• 🏥 Salud: **$180.000** (10%)\n• 🎭 Entretenimiento: **$150.000** (8%)\n\n¿Te gustaría optimizar alguna categoría?",
    ],
    ingresos: [
        "Tus ingresos registrados este mes son **$3.200.000**. En comparación con el mes anterior ($3.050.000), tuviste un incremento del **4.9%** 📈\n\n¡Excelente tendencia! ¿Quieres analizar cómo maximizar este ingreso?",
        "Registré los siguientes ingresos:\n• 💼 Sueldo principal: **$2.800.000**\n• 📊 Ingreso freelance: **$250.000**\n• 💰 Otros: **$150.000**\n\nTotal: **$3.200.000**",
    ],
    metas: [
        "Tu meta **\"Vacaciones Europa\"** tiene un progreso del **62%** — llevas $620.000 de $1.000.000.\n\nA tu ritmo actual, alcanzarías la meta en **4 meses**. Si aumentas el ahorro mensual en $50.000, la lograrías en **3 meses** 🎯",
        "Tienes **2 metas activas**:\n1. 🏖️ Vacaciones Europa: 62% ($620.000/$1.000.000)\n2. 🚗 Auto nuevo: 28% ($840.000/$3.000.000)\n\n¿Quieres ajustar los aportes mensuales para alguna de ellas?",
    ],
    deudas: [
        "No registro deudas activas en tu perfil. ¡Eso es fantástico! 🎉\n\nMantener una posición libre de deudas te da mayor flexibilidad financiera. ¿Te gustaría información sobre cómo aprovechar esa capacidad de endeudamiento de forma inteligente?",
        "Para una gestión saludable de deudas, lo ideal es que el **total de cuotas no supere el 30%** de tus ingresos.\n\nEn tu caso, ese límite sería **$960.000** mensuales. Tienes un amplio margen disponible si necesitas financiamiento.",
    ],
    inversiones: [
        "Con un margen de ahorro de **$393.000 mensuales**, podrías considerar:\n• 📈 **Fondos mutuos**: Bajo riesgo, liquidez inmediata\n• 🏦 **Depósito a plazo**: 0.4% mensual aprox.\n• 📊 **ETFs globales**: Diversificación internacional\n\n⚠️ Esta es información orientativa. Consulta a un asesor financiero certificado para decisiones de inversión.",
        "Antes de invertir, te recomiendo:\n1. Tener un **fondo de emergencia** (3-6 meses de gastos = $5.670.000)\n2. Tu fondo actual cubre aproximadamente **1.2 meses** — hay espacio para fortalecer esto primero.\n\n¿Quieres saber cómo construir tu fondo de emergencia?",
    ],
    emergencia: [
        "Un fondo de emergencia saludable debería cubrir entre **3 y 6 meses** de gastos.\n\nTus gastos mensuales: **$1.890.000**\n• Mínimo recomendado (3 meses): $5.670.000\n• Ideal (6 meses): $11.340.000\n\nTe sugiero destinar al menos **$200.000 mensuales** exclusivamente a este fondo hasta alcanzar el mínimo.",
    ],
    salud: [
        "Tu **salud financiera actual es 82/100** — clasificación: **Muy buena** 💪\n\nPuntos fuertes:\n✅ Sin deudas activas\n✅ Ahorro constante\n✅ Ingresos estables\n\nÁreas de mejora:\n⚠️ Fondo de emergencia incompleto\n⚠️ Diversificación de ingresos",
        "Tu score de **82/100** se compone de:\n• Liquidez: 85/100\n• Ahorro: 78/100\n• Endeudamiento: 95/100\n• Planificación: 70/100\n\nMejorar tu **planificación** a largo plazo es la acción con mayor impacto potencial.",
    ],
    presupuesto: [
        "Te propongo un presupuesto mensual basado en tu situación:\n\n**Ingresos totales: $3.200.000**\n\n• 🏠 Necesidades esenciales: $1.600.000 (50%)\n• 🎯 Metas y ahorro: $640.000 (20%)\n• 🎭 Gastos personales: $640.000 (20%)\n• 🚨 Fondo emergencia: $320.000 (10%)\n\n¿Quieres ajustar alguna categoría?",
    ],
    agradecimiento: [
        "¡Con gusto! Estoy aquí para ayudarte siempre que lo necesites 😊\n\nRecuerda que puedes consultarme sobre tus gastos, metas, ahorro o cualquier duda financiera.",
        "¡Para eso estoy! Seguiré monitoreando tu situación financiera y te avisaré si detecto oportunidades de mejora 🤖💜",
    ],
    default: [
        "Entiendo tu pregunta. Como asistente financiero, puedo ayudarte con:\n• 💰 Análisis de gastos e ingresos\n• 🎯 Planificación de metas\n• 📊 Presupuestos personales\n• 🚨 Alertas de seguridad\n• 💡 Consejos de ahorro\n\n¿Sobre cuál de estos temas quieres profundizar?",
        "Esa es una buena pregunta. Aunque necesito más contexto para darte una respuesta precisa, puedo decirte que con tus finanzas actuales tienes una base sólida para avanzar.\n\n¿Podrías contarme más sobre lo que necesitas analizar?",
        "Estoy aprendiendo constantemente para darte mejores respuestas 🤖\n\nPor ahora puedo ayudarte con análisis de gastos, planificación de ahorro y consultas sobre tu salud financiera. ¿Te puedo ayudar con alguno de estos temas?",
    ],
};
