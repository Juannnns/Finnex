@extends('layouts.auth')

@section('title', 'Iniciar sesión')

@section('content')
<div class="auth-shell">

    {{-- Left: Branding --}}
    <div class="auth-left">
        <div class="auth-left-content">

            {{-- Logo Icon --}}
            <div class="auth-brand-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
                    <polyline points="16 7 22 7 22 13"/>
                </svg>
            </div>

            {{-- Brand Name --}}
            <div style="font-size: 42px; font-weight: 900; color: white; letter-spacing: -2px; margin-bottom: 8px;">
                FINNEX
            </div>
            <div style="font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.6); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 40px;">
                Ecosistema Financiero Digital
            </div>

            <p class="auth-description">
                Organiza tus finanzas, recibe orientación inteligente e identifica posibles riesgos con herramientas accesibles para todos.
            </p>

            {{-- Module Highlights --}}
            <div class="auth-features">
                <div class="auth-feature-item">
                    <span style="width:32px;height:32px;background:rgba(255,255,255,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">🤖</span>
                    <div>
                        <strong style="color:white;font-size:13px;">FIN-BOT</strong>
                        <div style="font-size:12px;color:rgba(255,255,255,0.6);">Asistente financiero inteligente</div>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <span style="width:32px;height:32px;background:rgba(255,255,255,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">📊</span>
                    <div>
                        <strong style="color:white;font-size:13px;">FIN-360</strong>
                        <div style="font-size:12px;color:rgba(255,255,255,0.6);">Análisis financiero completo</div>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <span style="width:32px;height:32px;background:rgba(255,255,255,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">🛡️</span>
                    <div>
                        <strong style="color:white;font-size:13px;">FIN-SAFE</strong>
                        <div style="font-size:12px;color:rgba(255,255,255,0.6);">Seguridad y prevención de fraude</div>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <span style="width:32px;height:32px;background:rgba(255,255,255,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">♿</span>
                    <div>
                        <strong style="color:white;font-size:13px;">FIN-EASY</strong>
                        <div style="font-size:12px;color:rgba(255,255,255,0.6);">Accesibilidad e inclusión</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Right: Form --}}
    <div class="auth-right">
        <div class="auth-form-card">

            <h1 class="auth-form-title">Bienvenido de vuelta</h1>
            <p class="auth-form-subtitle">Ingresa a tu ecosistema financiero personal</p>

            {{-- Cuentas disponibles --}}
            <div style="background:var(--bg-card-2);border:1px solid var(--border-primary);border-radius:12px;padding:14px 16px;margin-bottom:20px;">
                <div style="font-size:12px;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">
                    Cuentas de prueba (MySQL Clever Cloud):
                </div>
                <div style="display:flex;gap:8px;flex-direction:column;">
                    <button type="button" onclick="selectUser('carlos@finnex.com', 'finnex2024')" style="background:rgba(124,58,237,0.15);border:1px solid rgba(124,58,237,0.4);border-radius:8px;padding:8px 12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;text-align:left;color:white;">
                        <div>
                            <div style="font-weight:700;font-size:13px;color:var(--color-primary-light);">👤 Carlos Mendoza (Admin)</div>
                            <div style="font-size:11px;color:var(--text-muted);">carlos@finnex.com · Saldo: $8.500.000</div>
                        </div>
                        <span style="font-size:11px;background:var(--gradient-brand);color:white;padding:3px 8px;border-radius:6px;font-weight:600;">Usar cuenta</span>
                    </button>

                    <button type="button" onclick="selectUser('sofia@finnex.com', 'finnex2024')" style="background:rgba(96,165,250,0.15);border:1px solid rgba(96,165,250,0.4);border-radius:8px;padding:8px 12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;text-align:left;color:white;">
                        <div>
                            <div style="font-weight:700;font-size:13px;color:#93C5FD;">👤 Sofía Ramírez (Admin)</div>
                            <div style="font-size:11px;color:var(--text-muted);">sofia@finnex.com · Saldo: $4.250.000</div>
                        </div>
                        <span style="font-size:11px;background:rgba(96,165,250,0.3);color:white;padding:3px 8px;border-radius:6px;font-weight:600;">Usar cuenta</span>
                    </button>
                </div>
                <div style="font-size:11px;color:var(--text-muted);margin-top:8px;text-align:center;">
                    Contraseña para ambas: <strong style="color:var(--text-primary);">finnex2024</strong>
                </div>
            </div>

            {{-- Error Message --}}
            @if ($errors->any())
                <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:12px;padding:12px 16px;margin-bottom:20px;color:#EF4444;font-size:13px;">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.post') }}" id="login-form">
                @csrf

                <div style="display:flex;flex-direction:column;gap:20px;">

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label" for="email">Correo electrónico</label>
                        <div class="form-input-icon-wrapper">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                placeholder="tu@correo.com"
                                value="{{ old('email', 'carlos@finnex.com') }}"
                                autocomplete="email"
                                required
                                aria-label="Correo electrónico"
                            >
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="form-input-icon-wrapper" style="position:relative;">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input"
                                placeholder="••••••••"
                                autocomplete="current-password"
                                required
                                aria-label="Contraseña"
                            >
                            <button type="button" id="toggle-password" aria-label="Mostrar contraseña"
                                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember / Forgot --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" id="remember" name="remember" style="accent-color:var(--color-primary);">
                            <span style="font-size:13px;color:var(--text-secondary);">Recordarme</span>
                        </label>
                        <a href="#" style="font-size:13px;color:var(--color-primary-light);">¿Olvidaste tu contraseña?</a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn btn-primary btn-lg w-full" id="login-submit-btn" style="width:100%;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        Iniciar sesión
                    </button>

                </div>
            </form>

            {{-- Footer --}}
            <p style="text-align:center;margin-top:32px;font-size:12px;color:var(--text-muted);">
                Al iniciar sesión aceptas nuestros
                <a href="#" style="color:var(--color-primary-light);">Términos de servicio</a>
                y
                <a href="#" style="color:var(--color-primary-light);">Política de privacidad</a>
            </p>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Toggle password visibility
const toggleBtn = document.getElementById('toggle-password');
const passwordInput = document.getElementById('password');
if (toggleBtn && passwordInput) {
    toggleBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
    });
}

function selectUser(email, pass) {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    if (emailInput) emailInput.value = email;
    if (passwordInput) passwordInput.value = pass;
}

// Pre-fill default password
if (passwordInput) {
    passwordInput.value = 'finnex2024';
}

// Submit loading state
const form = document.getElementById('login-form');
const submitBtn = document.getElementById('login-submit-btn');
if (form && submitBtn) {
    form.addEventListener('submit', () => {
        submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spinning"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Ingresando...';
        submitBtn.disabled = true;
    });
}
</script>
<style>
.spinning { animation: spin 1s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endpush
