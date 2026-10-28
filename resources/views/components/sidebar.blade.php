{{-- FINNEX Sidebar Component --}}
<aside class="sidebar" id="main-sidebar" role="navigation" aria-label="Navegación principal">

    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="sidebar-logo" title="Ir al Dashboard" aria-label="FINNEX - Ir al Dashboard">
        <div class="sidebar-logo-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
            </svg>
        </div>
        <span class="sidebar-logo-text">FINNEX</span>
    </a>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Principal --}}
        <div class="sidebar-section-label">Principal</div>

        <a href="{{ route('dashboard') }}"
           id="nav-dashboard"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/>
                <rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/>
            </svg>
            Dashboard
        </a>

        {{-- Módulos --}}
        <div class="sidebar-section-label" style="margin-top: 8px;">Módulos</div>

        <a href="{{ route('finbot') }}"
           id="nav-finbot"
           class="sidebar-link {{ request()->routeIs('finbot') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            FIN-BOT
        </a>

        <a href="{{ route('fin360') }}"
           id="nav-fin360"
           class="sidebar-link {{ request()->routeIs('fin360') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            FIN-360
        </a>


        <a href="{{ route('finsafe') }}"
           id="nav-finsafe"
           class="sidebar-link {{ request()->routeIs('finsafe') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            FIN-SAFE
        </a>

        <a href="{{ route('calculator') }}"
           id="nav-calculator"
           class="sidebar-link {{ request()->routeIs('calculator') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
            </svg>
            FIN-CALCULATOR
        </a>

        {{-- Transferencias --}}
        <a href="{{ route('transfers') }}"
           id="nav-transfers"
           class="sidebar-link {{ request()->routeIs('transfers') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <polyline points="19 12 12 19 5 12"/>
            </svg>
            Transferencias
        </a>

        {{-- Account --}}
        <div class="sidebar-section-label" style="margin-top: 8px;">Cuenta</div>

        <a href="{{ route('profile') }}"
           id="nav-profile"
           class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Perfil
        </a>

        <a href="{{ route('settings') }}"
           id="nav-settings"
           class="sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }}">
            <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            Configuración
        </a>

    </nav>

    {{-- User Footer --}}
    <div class="sidebar-footer">
        @php $sidebarUser = $authUser ?? null; @endphp
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ $sidebarUser ? strtoupper(substr($sidebarUser->name, 0, 1)) : 'U' }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ $sidebarUser?->name ?? 'Usuario' }}</div>
                <div class="sidebar-user-role">{{ $sidebarUser?->role ?? 'Admin' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-left: auto;">
                @csrf
                <button type="submit" title="Cerrar sesión" style="background:none;border:none;cursor:pointer;color:var(--text-muted);display:flex;align-items:center;" aria-label="Cerrar sesión">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>
