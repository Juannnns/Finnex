/**
 * FINNEX — Main Application JavaScript
 * app.js
 */

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initTopbarActions();
    initAnimations();
    loadA11ySettings();
});

/* ================================================
   SIDEBAR (Mobile)
   ================================================ */
function initSidebar() {
    const hamburger  = document.getElementById('hamburger-btn');
    const sidebar    = document.getElementById('main-sidebar');
    const overlay    = document.getElementById('sidebar-overlay');

    if (!hamburger || !sidebar) return;

    function openSidebar() {
        sidebar.classList.add('open');
        if (overlay) overlay.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('visible');
        document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    if (overlay) overlay.addEventListener('click', closeSidebar);

    // Close on resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebar();
    });
}

/* ================================================
   TOPBAR
   ================================================ */
function initTopbarActions() {
    // Notification button animation
    const notifBtn = document.getElementById('notif-btn');
    if (notifBtn) {
        notifBtn.addEventListener('click', () => {
            notifBtn.classList.add('shake');
            setTimeout(() => notifBtn.classList.remove('shake'), 500);
        });
    }
}

/* ================================================
   SCROLL ANIMATIONS
   ================================================ */
function initAnimations() {
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = `${i * 0.05}s`;
                    entry.target.classList.add('animate-fade-up');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.stat-card, .card').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    }
}

/* ================================================
   MODALS
   ================================================ */
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
}

// Close modal on overlay click
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('open');
        document.body.style.overflow = '';
    }
});

// Expose globally
window.openModal  = openModal;
window.closeModal = closeModal;

/* ================================================
   ACCESSIBILITY
   ================================================ */
function loadA11ySettings() {
    const settings = JSON.parse(localStorage.getItem('finnex_a11y') || '{}');
    applyA11ySettings(settings);
}

function applyA11ySettings(settings) {
    const body = document.body;
    body.classList.remove('a11y-high-contrast', 'a11y-large-text', 'a11y-xlarge-text', 'a11y-simplified', 'a11y-no-animations');

    if (settings.highContrast)  body.classList.add('a11y-high-contrast');
    if (settings.textSize === 'large')  body.classList.add('a11y-large-text');
    if (settings.textSize === 'xlarge') body.classList.add('a11y-xlarge-text');
    if (settings.simplified)    body.classList.add('a11y-simplified');
    if (!settings.animations && settings.animations !== undefined) body.classList.add('a11y-no-animations');
}

function saveA11ySetting(key, value) {
    const settings = JSON.parse(localStorage.getItem('finnex_a11y') || '{}');
    settings[key] = value;
    localStorage.setItem('finnex_a11y', JSON.stringify(settings));
    applyA11ySettings(settings);
}

window.saveA11ySetting = saveA11ySetting;
window.applyA11ySettings = applyA11ySettings;

/* ================================================
   HEALTH SCORE CIRCLE (SVG)
   ================================================ */
function initHealthScoreCircle(elementId, score, color = '#7C3AED') {
    const el = document.getElementById(elementId);
    if (!el) return;

    const radius = 54;
    const circumference = 2 * Math.PI * radius;
    const offset = circumference - (score / 100) * circumference;

    el.style.strokeDasharray  = circumference;
    el.style.strokeDashoffset = circumference;

    requestAnimationFrame(() => {
        setTimeout(() => {
            el.style.transition = 'stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
            el.style.strokeDashoffset = offset;
        }, 300);
    });
}

window.initHealthScoreCircle = initHealthScoreCircle;

/* ================================================
   PROGRESS BARS ANIMATION
   ================================================ */
function animateProgressBars() {
    document.querySelectorAll('.progress-bar-fill[data-width]').forEach(bar => {
        const targetWidth = bar.dataset.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = targetWidth + '%';
        }, 300);
    });
}

window.animateProgressBars = animateProgressBars;
document.addEventListener('DOMContentLoaded', animateProgressBars);

/* ================================================
   NUMBERS FORMAT
   ================================================ */
function formatCurrency(amount, currency = 'CLP') {
    return new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 0,
    }).format(amount);
}

window.formatCurrency = formatCurrency;
