{{-- FINNEX Bottom Nav Component (Mobile App) --}}
<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        <span>Inicio</span>
    </a>

    <a href="{{ route('fin360') }}" class="bottom-nav-item {{ request()->routeIs('fin360') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
        <span>360°</span>
    </a>

    <a href="{{ route('finbot') }}" class="bottom-nav-item {{ request()->routeIs('finbot') ? 'active' : '' }}">
        <div class="bottom-nav-center-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>
        <span>FIN-BOT</span>
    </a>

    <a href="{{ route('finsafe') }}" class="bottom-nav-item {{ request()->routeIs('finsafe') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        <span>Seguridad</span>
        @php $pendingAlerts = 2; @endphp
        @if($pendingAlerts > 0)
            <span class="nav-badge"></span>
        @endif
    </a>

    <a href="{{ route('profile') }}" class="bottom-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        <span>Perfil</span>
    </a>
</nav>
