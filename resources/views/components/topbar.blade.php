{{-- FINNEX Topbar Component (Mobile App) --}}
<header class="topbar mobile-topbar" role="banner" style="position:relative; z-index:50;">

    {{-- Title Area --}}
    <div class="topbar-title">
        <div style="display:flex;align-items:center;gap:8px;">
            <div style="width:28px;height:28px;background:var(--gradient-brand);border-radius:6px;display:flex;align-items:center;justify-content:center;box-shadow:0 0 10px rgba(124,58,237,0.4);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            </div>
            <div id="page-title-text">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-subtitle" id="page-subtitle-text" style="font-size:11px;">@yield('page-subtitle', '')</div>
    </div>

    {{-- Actions --}}
    <div class="topbar-actions">

        {{-- Date --}}
        <div class="text-secondary text-sm" style="display:none" id="topbar-date">
            {{ now()->locale('es')->isoFormat('D [de] MMMM, YYYY') }}
        </div>

        {{-- Language Toggle --}}
        <button class="topbar-btn" id="lang-toggle-btn" title="Cambiar idioma / Change language" aria-label="Cambiar idioma">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="2" y1="12" x2="22" y2="12"/>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
        </button>

        {{-- Notifications --}}
        <div style="position:relative;">
            <button class="topbar-btn" id="notif-btn" title="Notificaciones" aria-label="Ver notificaciones">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <span class="notification-dot" id="notif-dot"></span>
            </button>
            <div id="notif-dropdown" class="card animate-fade-up" style="display:none; position:absolute; top:40px; right:0; width:300px; padding:0; z-index:100; box-shadow:0 10px 40px rgba(0,0,0,0.5);">
                <div style="padding:16px; border-bottom:1px solid var(--border-subtle); font-weight:700;">Notificaciones</div>
                <div id="notif-list" style="max-height:300px; overflow-y:auto;">
                    <div style="padding:16px; border-bottom:1px solid var(--border-subtle); cursor:pointer;" onclick="this.style.opacity=0.5; document.getElementById('notif-dot').style.display='none';">
                        <div style="font-size:12px; font-weight:700; color:var(--text-primary);">¡Límite de presupuesto cerca!</div>
                        <div style="font-size:11px; color:var(--text-secondary); margin-top:4px;">Has usado el 80% de tu presupuesto de entretenimiento.</div>
                        <div style="font-size:10px; color:var(--color-primary-light); margin-top:8px;">Hace 2 horas</div>
                    </div>
                    <div style="padding:16px; cursor:pointer;" onclick="this.style.opacity=0.5;">
                        <div style="font-size:12px; font-weight:700; color:var(--text-primary);">Nuevo logro 🏆</div>
                        <div style="font-size:11px; color:var(--text-secondary); margin-top:4px;">Ahorraste $50,000 extra este mes.</div>
                        <div style="font-size:10px; color:var(--color-primary-light); margin-top:8px;">Ayer</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Avatar --}}
        @php
            $displayUser = $authUser ?? null;
            $displayName = $displayUser ? $displayUser->name : 'Usuario';
        @endphp
        <a href="{{ route('profile') }}" class="sidebar-avatar" style="cursor:pointer;width:36px;height:36px;font-size:13px;text-decoration:none;display:flex;align-items:center;justify-content:center;" title="{{ $displayName }}">
            {{ strtoupper(substr($displayName, 0, 1)) }}
        </a>

    </div>
</header>

@push('scripts')
<script>
    // Show date when screen is wide enough
    function updateTopbarDate() {
        const dateEl = document.getElementById('topbar-date');
        if (dateEl) dateEl.style.display = window.innerWidth > 900 ? 'block' : 'none';
    }
    updateTopbarDate();
    window.addEventListener('resize', updateTopbarDate);

    // Notifications Dropdown
    const notifBtn = document.getElementById('notif-btn');
    const notifDropdown = document.getElementById('notif-dropdown');
    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown.style.display = notifDropdown.style.display === 'none' ? 'block' : 'none';
        });
        document.addEventListener('click', () => {
            notifDropdown.style.display = 'none';
        });
        notifDropdown.addEventListener('click', e => e.stopPropagation());
    }

    // Language toggle functionality
    const langBtn = document.getElementById('lang-toggle-btn');
    let currentLang = 'es';
    
    const dictionary = {
        'en': {
            'Dashboard': 'Dashboard',
            'Perfil': 'Profile',
            'Configuración': 'Settings',
            'Módulos': 'Modules',
            'Cuenta': 'Account',
            'Principal': 'Main',
            'Notificaciones': 'Notifications',
            '¡Límite de presupuesto cerca!': 'Budget limit approaching!',
            'Has usado el 80% de tu presupuesto de entretenimiento.': 'You have used 80% of your entertainment budget.',
            'Nuevo logro 🏆': 'New achievement 🏆',
            'Ahorraste $50,000 extra este mes.': 'You saved an extra $50,000 this month.',
            'Hace 2 horas': '2 hours ago',
            'Ayer': 'Yesterday'
        },
        'es': {
            'Dashboard': 'Dashboard',
            'Profile': 'Perfil',
            'Settings': 'Configuración',
            'Modules': 'Módulos',
            'Account': 'Cuenta',
            'Main': 'Principal',
            'Notifications': 'Notificaciones',
            'Budget limit approaching!': '¡Límite de presupuesto cerca!',
            'You have used 80% of your entertainment budget.': 'Has usado el 80% de tu presupuesto de entretenimiento.',
            'New achievement 🏆': 'Nuevo logro 🏆',
            'You saved an extra $50,000 this month.': 'Ahorraste $50,000 extra este mes.',
            '2 hours ago': 'Hace 2 horas',
            'Yesterday': 'Ayer'
        }
    };

    function translatePage() {
        const dict = dictionary[currentLang];
        
        // Translate Sidebar Links
        document.querySelectorAll('.sidebar-link').forEach(link => {
            const textNode = Array.from(link.childNodes).find(n => n.nodeType === 3 && n.textContent.trim().length > 0);
            if(textNode) {
                const originalText = textNode.textContent.trim();
                if(dict[originalText]) textNode.textContent = ' ' + dict[originalText];
            }
        });
        
        // Translate Sidebar Section Labels
        document.querySelectorAll('.sidebar-section-label').forEach(label => {
            const txt = label.textContent.trim();
            if(dict[txt]) label.textContent = dict[txt];
        });

        // Translate Notifications
        document.querySelectorAll('#notif-dropdown div').forEach(div => {
            if(div.childNodes.length === 1 && div.childNodes[0].nodeType === 3) {
                const txt = div.textContent.trim();
                if(dict[txt]) div.textContent = dict[txt];
            }
        });
    }

    if (langBtn) {
        langBtn.addEventListener('click', () => {
            currentLang = currentLang === 'es' ? 'en' : 'es';
            langBtn.title = currentLang === 'es' ? 'Cambiar idioma / Change language' : 'Switch language / Cambiar idioma';
            translatePage();
        });
    }

    // Hamburger aria
    const hamburger = document.getElementById('hamburger-btn');
    const sidebar   = document.getElementById('main-sidebar');
    if (hamburger && sidebar) {
        const observer = new MutationObserver(() => {
            hamburger.setAttribute('aria-expanded', sidebar.classList.contains('open'));
        });
        observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
    }
</script>
@endpush
