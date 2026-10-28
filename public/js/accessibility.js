/**
 * FINNEX — Accessibility Controls (FIN-EASY)
 * accessibility.js
 */

document.addEventListener('DOMContentLoaded', () => {
    initA11yPanel();
    initA11yFloatingButton();
    loadA11yPreferences();
});

/* ================================================
   LOAD & APPLY SAVED PREFERENCES
   ================================================ */
function loadA11yPreferences() {
    const prefs = getPrefs();
    applyPreferences(prefs);
    syncUIToPreferences(prefs);
}

function getPrefs() {
    try {
        return JSON.parse(localStorage.getItem('finnex_a11y') || '{}');
    } catch {
        return {};
    }
}

function savePrefs(prefs) {
    localStorage.setItem('finnex_a11y', JSON.stringify(prefs));
    applyPreferences(prefs);
}

function applyPreferences(prefs) {
    const body = document.body;

    // Remove all a11y classes first
    body.classList.remove(
        'a11y-high-contrast',
        'a11y-large-text',
        'a11y-xlarge-text',
        'a11y-simplified',
        'a11y-no-animations'
    );

    if (prefs.highContrast)  body.classList.add('a11y-high-contrast');
    if (prefs.textSize === 'large')  body.classList.add('a11y-large-text');
    if (prefs.textSize === 'xlarge') body.classList.add('a11y-xlarge-text');
    if (prefs.simplified)    body.classList.add('a11y-simplified');
    if (prefs.animations === false)  body.classList.add('a11y-no-animations');

    // Clear text (plain language)
    if (prefs.clearLanguage) {
        document.documentElement.lang = 'es';
    }
}

function syncUIToPreferences(prefs) {
    // Toggle switches
    syncToggle('a11y-high-contrast-toggle',  prefs.highContrast);
    syncToggle('a11y-simplified-toggle',     prefs.simplified);
    syncToggle('a11y-animations-toggle',     prefs.animations !== false);
    syncToggle('a11y-clear-language-toggle', prefs.clearLanguage);

    // Text size buttons
    const size = prefs.textSize || 'normal';
    document.querySelectorAll('.text-size-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.size === size);
    });
}

function syncToggle(id, value) {
    const el = document.getElementById(id);
    if (el) el.checked = !!value;
}

/* ================================================
   PANEL CONTROLS
   ================================================ */
function initA11yPanel() {
    // High Contrast
    bindToggle('a11y-high-contrast-toggle', (checked) => {
        const prefs = getPrefs();
        prefs.highContrast = checked;
        savePrefs(prefs);
        showToast(checked ? 'Alto contraste activado' : 'Alto contraste desactivado');
    });

    // Simplified UI
    bindToggle('a11y-simplified-toggle', (checked) => {
        const prefs = getPrefs();
        prefs.simplified = checked;
        savePrefs(prefs);
        showToast(checked ? 'Interfaz simplificada activada' : 'Interfaz normal restaurada');
    });

    // Animations
    bindToggle('a11y-animations-toggle', (checked) => {
        const prefs = getPrefs();
        prefs.animations = checked;
        savePrefs(prefs);
        showToast(checked ? 'Animaciones activadas' : 'Animaciones desactivadas');
    });

    // Clear Language
    bindToggle('a11y-clear-language-toggle', (checked) => {
        const prefs = getPrefs();
        prefs.clearLanguage = checked;
        savePrefs(prefs);
        showToast(checked ? 'Lenguaje claro activado' : 'Lenguaje técnico restaurado');
    });

    // Text Size Buttons
    document.querySelectorAll('.text-size-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const size = btn.dataset.size;
            const prefs = getPrefs();
            prefs.textSize = size;
            savePrefs(prefs);
            syncUIToPreferences(prefs);
            showToast('Tamaño de texto: ' + btn.textContent.trim());
        });
    });

    // Reset button
    const resetBtn = document.getElementById('a11y-reset-btn');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            localStorage.removeItem('finnex_a11y');
            loadA11yPreferences();
            showToast('Configuración de accesibilidad reiniciada');
        });
    }
}

function bindToggle(id, callback) {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('change', () => callback(el.checked));
    }
}

/* ================================================
   FLOATING BUTTON
   ================================================ */
function initA11yFloatingButton() {
    const btn = document.getElementById('floating-finbot-btn') || document.getElementById('a11y-floating-btn');
    if (!btn) return;

    if (btn.tagName === 'BUTTON') {
        btn.addEventListener('click', () => {
            window.location.href = '/finbot';
        });
    }
}

/* ================================================
   TOAST NOTIFICATIONS
   ================================================ */
function showToast(message, type = 'info') {
    // Remove existing toast
    const existing = document.getElementById('finnex-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'finnex-toast';
    toast.style.cssText = `
        position: fixed;
        bottom: 84px;
        right: 24px;
        background: #1A1140;
        border: 1px solid rgba(167,139,250,0.3);
        border-radius: 12px;
        padding: 12px 20px;
        color: #F1F5F9;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        max-width: 280px;
        display: flex;
        align-items: center;
        gap: 8px;
    `;

    const icons = {
        info: '✨',
        success: '✅',
        warning: '⚠️',
        error: '❌',
    };

    toast.innerHTML = `<span>${icons[type] || icons.info}</span><span>${message}</span>`;
    document.body.appendChild(toast);

    // Auto remove
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Inject toast animations if not present
const toastStyle = document.createElement('style');
toastStyle.textContent = `
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(20px); }
    }
`;
document.head.appendChild(toastStyle);

window.showToast = showToast;
