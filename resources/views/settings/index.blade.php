@extends('layouts.app')

@section('title', 'Configuración')
@section('page-title', 'Configuración')
@section('page-subtitle', 'Preferencias del sistema, accesibilidad y módulos Beta')

@section('content')
<div class="settings-container animate-fade-up">

    {{-- Alert Feedback --}}
    @if(session('success'))
        <div class="alert-banner alert-success animate-fade-up" id="alert-settings-ok">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Layout: Sidebar Navigation + Content Panel --}}
    <div class="settings-layout">

        {{-- Left: Section Navigation Menu --}}
        <aside class="settings-nav-card card">
            <div class="settings-nav-header">
                <div class="settings-nav-title">Secciones</div>
                <span class="badge-beta-nav">v1.2 Beta</span>
            </div>

            <nav class="settings-nav-list" role="tablist" aria-label="Secciones de configuración">
                <button type="button" class="settings-nav-btn active" data-target="sec-accessibility" role="tab" aria-selected="true">
                    <span class="settings-nav-icon icon-a11y">♿</span>
                    <span class="settings-nav-label">Accesibilidad</span>
                    <span class="badge-pill badge-primary">Especial</span>
                </button>

                <button type="button" class="settings-nav-btn" data-target="sec-notifications" role="tab" aria-selected="false">
                    <span class="settings-nav-icon">🔔</span>
                    <span class="settings-nav-label">Notificaciones</span>
                    <span class="badge-pill badge-beta">Beta</span>
                </button>

                <button type="button" class="settings-nav-btn" data-target="sec-display" role="tab" aria-selected="false">
                    <span class="settings-nav-icon">🎨</span>
                    <span class="settings-nav-label">Visualización</span>
                    <span class="badge-pill badge-beta">Beta</span>
                </button>

                <button type="button" class="settings-nav-btn" data-target="sec-privacy" role="tab" aria-selected="false">
                    <span class="settings-nav-icon">🛡️</span>
                    <span class="settings-nav-label">Privacidad & 2FA</span>
                    <span class="badge-pill badge-beta">Beta</span>
                </button>

                <button type="button" class="settings-nav-btn" data-target="sec-ai" role="tab" aria-selected="false">
                    <span class="settings-nav-icon">🤖</span>
                    <span class="settings-nav-label">FIN-BOT & IA</span>
                    <span class="badge-pill badge-beta">Beta</span>
                </button>

                <button type="button" class="settings-nav-btn" data-target="sec-data" role="tab" aria-selected="false">
                    <span class="settings-nav-icon">📦</span>
                    <span class="settings-nav-label">Datos & Respaldo</span>
                    <span class="badge-pill badge-beta">Beta</span>
                </button>

                <button type="button" class="settings-nav-btn" data-target="sec-danger" role="tab" aria-selected="false">
                    <span class="settings-nav-icon">⚠️</span>
                    <span class="settings-nav-label">Zona de Cuenta</span>
                    <span class="badge-pill badge-danger-pill">Peligro</span>
                </button>
            </nav>
        </aside>

        {{-- Right: Content Panels --}}
        <main class="settings-content-card">

            <form method="POST" action="{{ route('settings.update') }}" id="form-settings">
                @csrf
                <input type="hidden" name="active_section" id="hidden-active-section" value="{{ session('active_section', 'sec-accessibility') }}">

                {{-- ========================================== --}}
                {{-- 1. SECCIÓN: ACCESIBILIDAD                  --}}
                {{-- ========================================== --}}
                <div class="settings-panel active animate-fade-up" id="sec-accessibility">
                    <div class="card panel-card">
                        <div class="settings-section-header">
                            <div class="settings-icon-wrap" style="background: rgba(167, 139, 250, 0.2); color: var(--color-primary-light);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>
                                    <path d="M12 2a10 10 0 1 0 10 10"/><path d="m15 9-3 3-3-3"/>
                                </svg>
                            </div>
                            <div class="header-text-group">
                                <div class="header-title-row">
                                    <h2 class="settings-section-title">Accesibilidad & Inclusión</h2>
                                    <span class="badge-pill badge-primary">Módulo Activo</span>
                                </div>
                                <p class="settings-section-sub">Ajusta la interfaz para adaptarla a tus necesidades visuales, cognitivas o de navegación.</p>
                            </div>
                        </div>

                        <div class="beta-notice-banner">
                            <div class="notice-icon">💡</div>
                            <div class="notice-text">
                                <strong>Adaptación en tiempo real:</strong> Los cambios en accesibilidad se aplican inmediatamente en tu pantalla y se sincronizan con tu sesión.
                            </div>
                        </div>

                        {{-- Controles de Accesibilidad --}}
                        <div class="settings-toggle-list">

                            {{-- Alto Contraste --}}
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Modo Alto Contraste</div>
                                    <div class="toggle-desc">Fondo negro de alto contraste con bordes resaltados para facilitar la lectura visual.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="a11y_high_contrast" id="a11y-high-contrast-toggle" value="1"
                                           {{ !empty($settings['a11y_high_contrast']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            {{-- Tamaño de Fuente --}}
                            <div class="settings-toggle-item" style="align-items: flex-start;">
                                <div class="toggle-info">
                                    <div class="toggle-label">Tamaño del Texto</div>
                                    <div class="toggle-desc">Aumenta el tamaño tipográfico de toda la aplicación sin romper el diseño.</div>
                                </div>
                                <div class="font-size-selector">
                                    <input type="hidden" name="a11y_text_size" id="hidden-text-size" value="{{ $settings['a11y_text_size'] ?? 'normal' }}">
                                    <button type="button" class="text-size-btn {{ ($settings['a11y_text_size'] ?? 'normal') === 'normal' ? 'active' : '' }}" data-size="normal">
                                        Aa <span class="size-legend">Normal</span>
                                    </button>
                                    <button type="button" class="text-size-btn {{ ($settings['a11y_text_size'] ?? '') === 'large' ? 'active' : '' }}" data-size="large">
                                        Aa+ <span class="size-legend">Grande</span>
                                    </button>
                                    <button type="button" class="text-size-btn {{ ($settings['a11y_text_size'] ?? '') === 'xlarge' ? 'active' : '' }}" data-size="xlarge">
                                        Aa++ <span class="size-legend">Extra</span>
                                    </button>
                                </div>
                            </div>

                            {{-- Reducir Movimiento / Animaciones --}}
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Reducir Movimiento y Animaciones</div>
                                    <div class="toggle-desc">Desactiva transiciones y animaciones para personas sensibles al movimiento o con fatiga visual.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="a11y_no_animations" id="a11y-animations-toggle" value="1"
                                           {{ !empty($settings['a11y_no_animations']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            {{-- Interfaz Simplificada --}}
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Modo Interfaz Simplificada</div>
                                    <div class="toggle-desc">Oculta efectos decorativos, blur de fondo y sombras pesadas para máxima claridad mental.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="a11y_simplified" id="a11y-simplified-toggle" value="1"
                                           {{ !empty($settings['a11y_simplified']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            {{-- Lenguaje Claro --}}
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Lenguaje Claro y Sencillo</div>
                                    <div class="toggle-desc">Muestra descripciones intuitivas en lugar de terminología bancaria o financiera compleja.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="a11y_clear_language" id="a11y-clear-language-toggle" value="1"
                                           {{ !empty($settings['a11y_clear_language']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            {{-- Asistente de Voz / Lectura en Voz Alta --}}
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Lectura Asistida por Voz (Beta)</div>
                                    <div class="toggle-desc">Permite leer resúmenes financieros y descripciones en voz alta usando síntesis de voz.</div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <button type="button" class="btn btn-outline-sm" id="btn-test-speech">
                                        🔊 Probar voz
                                    </button>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="a11y_screen_reader" id="a11y-screen-reader-toggle" value="1"
                                               {{ !empty($settings['a11y_screen_reader']) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        {{-- Botón restablecer accesibilidad --}}
                        <div class="panel-footer-actions">
                            <button type="button" class="btn btn-outline-sm" id="a11y-reset-btn">
                                ↺ Restablecer valores de accesibilidad
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Guardar configuración
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- 2. SECCIÓN: NOTIFICACIONES (BETA)          --}}
                {{-- ========================================== --}}
                <div class="settings-panel animate-fade-up" id="sec-notifications" style="display: none;">
                    <div class="card panel-card">
                        <div class="settings-section-header">
                            <div class="settings-icon-wrap" style="background: rgba(96, 165, 250, 0.2); color: var(--color-accent-blue);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                </svg>
                            </div>
                            <div class="header-text-group">
                                <div class="header-title-row">
                                    <h2 class="settings-section-title">Canales de Notificación</h2>
                                    <span class="badge-pill badge-beta">Versión Beta</span>
                                </div>
                                <p class="settings-section-sub">Configuración básica de avisos, resúmenes y alertas automáticas en segundo plano.</p>
                            </div>
                        </div>

                        <div class="beta-notice-banner">
                            <div class="notice-icon">🧪</div>
                            <div class="notice-text">
                                <strong>Funcionalidad en prueba:</strong> Las alertas se simulan a través del panel de notificaciones superior y alertas de prueba.
                            </div>
                        </div>

                        <div class="settings-toggle-list">
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Notificaciones por correo electrónico</div>
                                    <div class="toggle-desc">Recibe extractos quincenales y confirmaciones al correo del perfil.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="notifications_email" id="notif-email" value="1"
                                           {{ !empty($settings['notifications_email']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Notificaciones en el navegador (Web Push)</div>
                                    <div class="toggle-desc">Avisos instantáneos cuando estás navegando en la plataforma.</div>
                                </div>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <button type="button" class="btn btn-outline-sm" id="btn-test-notification">Probar alerta</button>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="notifications_push" id="notif-push" value="1"
                                               {{ !empty($settings['notifications_push']) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Alertas de riesgo de FIN-SAFE</div>
                                    <div class="toggle-desc">Aviso urgente si se detectan cobros duplicados o movimientos inusuales.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="notifications_alerts" id="notif-alerts" value="1"
                                           {{ !empty($settings['notifications_alerts']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Resumen dominical de salud financiera</div>
                                    <div class="toggle-desc">Balance semanal con comparativa de gastos frente a la meta 50/30/20.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="notifications_weekly" id="notif-weekly" value="1"
                                           {{ !empty($settings['notifications_weekly']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="panel-footer-actions">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- 3. SECCIÓN: VISUALIZACIÓN & MONEDA (BETA)  --}}
                {{-- ========================================== --}}
                <div class="settings-panel animate-fade-up" id="sec-display" style="display: none;">
                    <div class="card panel-card">
                        <div class="settings-section-header">
                            <div class="settings-icon-wrap" style="background: rgba(192, 132, 252, 0.2); color: var(--color-accent-pink);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                </svg>
                            </div>
                            <div class="header-text-group">
                                <div class="header-title-row">
                                    <h2 class="settings-section-title">Visualización y Regionalización</h2>
                                    <span class="badge-pill badge-beta">Versión Beta</span>
                                </div>
                                <p class="settings-section-sub">Personaliza monedas, formato de presentación y tema base del ecosistema.</p>
                            </div>
                        </div>

                        <div class="beta-notice-banner">
                            <div class="notice-icon">🌐</div>
                            <div class="notice-text">
                                <strong>Funciones básicas:</strong> Ajusta los formatos visuales de moneda y fecha para sincronizarlos con tu región.
                            </div>
                        </div>

                        <div class="settings-form-grid">
                            <div class="form-group">
                                <label class="form-label" for="setting-currency">Moneda de visualización</label>
                                <select class="form-input form-select" id="setting-currency" name="currency">
                                    @foreach(['MXN' => '🇲🇽 MXN — Peso Mexicano', 'USD' => '🇺🇸 USD — Dólar', 'EUR' => '🇪🇺 EUR — Euro', 'COP' => '🇨🇴 COP — Peso Colombiano', 'ARS' => '🇦🇷 ARS — Peso Argentino'] as $val => $label)
                                        <option value="{{ $val }}" {{ ($settings['currency'] ?? 'MXN') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="setting-language">Idioma de la interfaz</label>
                                <select class="form-input form-select" id="setting-language" name="language">
                                    <option value="es" {{ ($settings['language'] ?? 'es') === 'es' ? 'selected' : '' }}>🇲🇽 Español (Latinoamérica)</option>
                                    <option value="en" {{ ($settings['language'] ?? 'es') === 'en' ? 'selected' : '' }}>🇺🇸 English (US)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="setting-theme">Tema de color</label>
                                <select class="form-input form-select" id="setting-theme" name="theme">
                                    <option value="dark" {{ ($settings['theme'] ?? 'dark') === 'dark' ? 'selected' : '' }}>🌙 Oscuro FINNEX (Recomendado)</option>
                                    <option value="light" {{ ($settings['theme'] ?? '') === 'light' ? 'selected' : '' }}>☀️ Claro (Alto Brillo)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="setting-date-format">Formato de fecha</label>
                                <select class="form-input form-select" id="setting-date-format" name="date_format">
                                    <option value="DD/MM/YYYY" {{ ($settings['date_format'] ?? 'DD/MM/YYYY') === 'DD/MM/YYYY' ? 'selected' : '' }}>DD/MM/AAAA (12/10/2026)</option>
                                    <option value="MM/DD/YYYY" {{ ($settings['date_format'] ?? '') === 'MM/DD/YYYY' ? 'selected' : '' }}>MM/DD/AAAA (10/12/2026)</option>
                                </select>
                            </div>
                        </div>

                        <div class="settings-toggle-list" style="margin-top: 16px;">
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Modo incógnito visual</div>
                                    <div class="toggle-desc">Oculta los saldos principales con asteriscos (••••) al abrir el dashboard hasta hacer clic.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="privacy_incognito" id="setting-incognito" value="1"
                                           {{ !empty($settings['privacy_incognito']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="panel-footer-actions">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- 4. SECCIÓN: PRIVACIDAD & 2FA (BETA)        --}}
                {{-- ========================================== --}}
                <div class="settings-panel animate-fade-up" id="sec-privacy" style="display: none;">
                    <div class="card panel-card">
                        <div class="settings-section-header">
                            <div class="settings-icon-wrap" style="background: rgba(245, 158, 11, 0.2); color: var(--color-warning);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </div>
                            <div class="header-text-group">
                                <div class="header-title-row">
                                    <h2 class="settings-section-title">Privacidad y Protección 2FA</h2>
                                    <span class="badge-pill badge-beta">Versión Beta</span>
                                </div>
                                <p class="settings-section-sub">Configuración de exposición de datos y autenticación de seguridad.</p>
                            </div>
                        </div>

                        <div class="beta-notice-banner">
                            <div class="notice-icon">🛡️</div>
                            <div class="notice-text">
                                <strong>Seguridad en prueba:</strong> Las funciones de verificación doble y bloqueo automático operan en modo simulación para este usuario.
                            </div>
                        </div>

                        <div class="settings-toggle-list">
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Visibilidad de tu cuenta</div>
                                    <div class="toggle-desc">Determina si otros usuarios de la red FINNEX pueden encontrarte por correo o alias.</div>
                                </div>
                                <div style="min-width: 150px;">
                                    <select class="form-input form-select" name="privacy_profile" id="setting-privacy" style="padding: 7px 12px; font-size: 13px;">
                                        <option value="private" {{ ($settings['privacy_profile'] ?? 'private') === 'private' ? 'selected' : '' }}>🔒 Privado</option>
                                        <option value="public"  {{ ($settings['privacy_profile'] ?? '') === 'public'  ? 'selected' : '' }}>🌐 Público</option>
                                    </select>
                                </div>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Autenticación en dos pasos (2FA)</div>
                                    <div class="toggle-desc">Solicita un código de verificación de 6 dígitos al iniciar sesión en nuevos dispositivos.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="two_factor" id="setting-2fa" value="1"
                                           {{ !empty($settings['two_factor']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Bloqueo por inactividad</div>
                                    <div class="toggle-desc">Tiempo de espera sin interacción antes de requerir volver a ingresar contraseña.</div>
                                </div>
                                <div style="min-width: 150px;">
                                    <select class="form-input form-select" name="session_timeout" id="setting-timeout" style="padding: 7px 12px; font-size: 13px;">
                                        <option value="15" {{ ($settings['session_timeout'] ?? '30') === '15' ? 'selected' : '' }}>15 minutos</option>
                                        <option value="30" {{ ($settings['session_timeout'] ?? '30') === '30' ? 'selected' : '' }}>30 minutos</option>
                                        <option value="60" {{ ($settings['session_timeout'] ?? '') === '60' ? 'selected' : '' }}>1 hora</option>
                                        <option value="never" {{ ($settings['session_timeout'] ?? '') === 'never' ? 'selected' : '' }}>Desactivado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer-actions">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- 5. SECCIÓN: FIN-BOT & IA (BETA)            --}}
                {{-- ========================================== --}}
                <div class="settings-panel animate-fade-up" id="sec-ai" style="display: none;">
                    <div class="card panel-card">
                        <div class="settings-section-header">
                            <div class="settings-icon-wrap" style="background: rgba(16, 185, 129, 0.2); color: var(--color-success);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    <circle cx="12" cy="17" r="1" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="header-text-group">
                                <div class="header-title-row">
                                    <h2 class="settings-section-title">FIN-BOT & Inteligencia Financiera</h2>
                                    <span class="badge-pill badge-beta">Versión Beta</span>
                                </div>
                                <p class="settings-section-sub">Ajustes básicos del asistente de chat inteligente y automatizaciones de análisis.</p>
                            </div>
                        </div>

                        <div class="beta-notice-banner">
                            <div class="notice-icon">🤖</div>
                            <div class="notice-text">
                                <strong>IA Experimental:</strong> FIN-BOT analiza patrones de transacciones para generar consejos automáticos en tu dashboard.
                            </div>
                        </div>

                        <div class="settings-toggle-list">
                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Consejos de ahorro proactivos</div>
                                    <div class="toggle-desc">Permite a FIN-BOT sugerir recortes de gastos cuando un presupuesto supera el 80%.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="beta_ai_insights" id="beta-ai-insights" value="1"
                                           {{ !empty($settings['beta_ai_insights']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Auto-categorización inteligente</div>
                                    <div class="toggle-desc">Asigna categorías automáticamente a movimientos nuevos usando coincidencia semántica.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="beta_auto_categorize" id="beta-auto-categorize" value="1"
                                           {{ !empty($settings['beta_auto_categorize']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Estilo de respuesta de FIN-BOT</div>
                                    <div class="toggle-desc">Selecciona qué tan explicativo debe ser el asistente en sus respuestas.</div>
                                </div>
                                <div style="min-width: 170px;">
                                    <select class="form-input form-select" name="beta_finbot_mode" id="setting-finbot-mode" style="padding: 7px 12px; font-size: 13px;">
                                        <option value="detailed" {{ ($settings['beta_finbot_mode'] ?? 'detailed') === 'detailed' ? 'selected' : '' }}>📚 Pedagógico y detallado</option>
                                        <option value="concise"  {{ ($settings['beta_finbot_mode'] ?? '') === 'concise'  ? 'selected' : '' }}>⚡ Breve y directo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="settings-toggle-item">
                                <div class="toggle-info">
                                    <div class="toggle-label">Pronóstico de saldo a fin de mes</div>
                                    <div class="toggle-desc">Calcula una proyección estimada de tu dinero disponible con base en gastos recurrentes.</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="beta_budget_forecast" id="beta-budget-forecast" value="1"
                                           {{ !empty($settings['beta_budget_forecast']) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="panel-footer-actions">
                            <button type="button" class="btn btn-outline-sm" id="btn-clear-bot-cache">
                                🧹 Vaciar memoria de conversación
                            </button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- 6. SECCIÓN: DATOS & RESPALDO (BETA)        --}}
                {{-- ========================================== --}}
                <div class="settings-panel animate-fade-up" id="sec-data" style="display: none;">
                    <div class="card panel-card">
                        <div class="settings-section-header">
                            <div class="settings-icon-wrap" style="background: rgba(96, 165, 250, 0.2); color: var(--color-accent-blue);">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                            </div>
                            <div class="header-text-group">
                                <div class="header-title-row">
                                    <h2 class="settings-section-title">Datos, Respaldo y Exportación</h2>
                                    <span class="badge-pill badge-beta">Versión Beta</span>
                                </div>
                                <p class="settings-section-sub">Descarga tus datos personales o expórtalos en formatos abiertos estándar.</p>
                            </div>
                        </div>

                        <div class="beta-notice-banner">
                            <div class="notice-icon">💾</div>
                            <div class="notice-text">
                                <strong>Exportador Beta:</strong> Genera un archivo `.json` estructurado con la información de sesión, perfil y configuraciones.
                            </div>
                        </div>

                        <div class="data-actions-grid">
                            <div class="data-action-card">
                                <div class="data-action-icon">📄</div>
                                <div class="data-action-body">
                                    <div class="data-action-title">Copia de Configuración</div>
                                    <div class="data-action-desc">Descarga un archivo con tus preferencias actuales y estado de cuenta demo.</div>
                                </div>
                                <a href="{{ route('settings.export') }}" class="btn btn-outline-sm" id="btn-export-json">
                                    Descargar JSON
                                </a>
                            </div>

                            <div class="data-action-card">
                                <div class="data-action-icon">📋</div>
                                <div class="data-action-body">
                                    <div class="data-action-title">Portapapeles Rápido</div>
                                    <div class="data-action-desc">Copia un resumen textual de tus configuraciones al portapapeles.</div>
                                </div>
                                <button type="button" class="btn btn-outline-sm" id="btn-copy-summary">
                                    Copiar texto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            {{-- ========================================== --}}
            {{-- 7. SECCIÓN: ZONA DE PELIGRO (BETA)         --}}
            {{-- ========================================== --}}
            <div class="settings-panel animate-fade-up" id="sec-danger" style="display: none;">
                <div class="card panel-card danger-zone-card">
                    <div class="settings-section-header">
                        <div class="settings-icon-wrap" style="background: rgba(239, 68, 68, 0.2); color: var(--color-danger);">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="10.29 3.86 1.82 18 2 18 22 18 22.18 18 13.71 3.86 10.29 3.86"/>
                                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                        </div>
                        <div class="header-text-group">
                            <div class="header-title-row">
                                <h2 class="settings-section-title" style="color: var(--color-danger);">Zona de Cuenta y Peligro</h2>
                                <span class="badge-pill badge-danger-pill">Acciones Irreversibles</span>
                            </div>
                            <p class="settings-section-sub">Opciones de restablecimiento de prueba y eliminación de la cuenta.</p>
                        </div>
                    </div>

                    <div class="danger-items-list">
                        {{-- Restablecer a valores de fábrica --}}
                        <div class="danger-item">
                            <div class="danger-info">
                                <div class="danger-title">Restablecer valores predeterminados (Beta)</div>
                                <div class="danger-desc">Borra las preferencias personalizadas de esta sesión y carga las opciones de fábrica.</div>
                            </div>
                            <form method="POST" action="{{ route('settings.reset-demo') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Restablecer todas las configuraciones a sus valores predeterminados?')">
                                    ↺ Restablecer valores
                                </button>
                            </form>
                        </div>

                        {{-- Eliminar cuenta --}}
                        <div class="danger-item" style="border-top: 1px solid rgba(239, 68, 68, 0.2); padding-top: 18px;">
                            <div class="danger-info">
                                <div class="danger-title" style="color: var(--color-danger);">Eliminar cuenta de usuario</div>
                                <div class="danger-desc">Borra la sesión activa y te redirige a la pantalla de inicio de sesión.</div>
                            </div>
                            <form method="POST" action="{{ route('settings.delete') }}" id="form-delete-account"
                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cuenta? Esta acción cerrará tu sesión.')">
                                @csrf
                                <button type="submit" class="btn btn-danger" id="btn-delete-account">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    Eliminar cuenta
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>

</div>

@push('styles')
<style>
/* Settings Layout */
.settings-container {
    max-width: 1080px;
    margin: 0 auto;
}

.settings-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
    align-items: flex-start;
}

/* Nav Menu Card */
.settings-nav-card {
    padding: 16px;
    position: sticky;
    top: calc(var(--topbar-height) + 20px);
}

.settings-nav-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 4px 8px 14px 8px;
    border-bottom: 1px solid var(--border-subtle);
    margin-bottom: 8px;
}

.settings-nav-title {
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--text-secondary);
}

.badge-beta-nav {
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: var(--radius-full);
    background: rgba(124, 58, 237, 0.2);
    color: var(--color-primary-light);
    border: 1px solid var(--border-subtle);
}

.settings-nav-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.settings-nav-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: var(--radius-md);
    background: transparent;
    border: 1px solid transparent;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    text-align: left;
    transition: all var(--transition-fast);
    width: 100%;
}

.settings-nav-btn:hover {
    background: var(--bg-card-hover);
    color: var(--text-primary);
}

.settings-nav-btn.active {
    background: rgba(124, 58, 237, 0.18);
    color: white;
    border-color: rgba(167, 139, 250, 0.35);
    font-weight: 600;
    box-shadow: 0 4px 14px rgba(124, 58, 237, 0.25);
}

.settings-nav-icon {
    font-size: 18px;
    line-height: 1;
    flex-shrink: 0;
}

.settings-nav-label {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Badges */
.badge-pill {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-primary {
    background: rgba(167, 139, 250, 0.25);
    color: #E9D5FF;
    border: 1px solid rgba(167, 139, 250, 0.4);
}

.badge-beta {
    background: rgba(96, 165, 250, 0.15);
    color: #93C5FD;
    border: 1px solid rgba(96, 165, 250, 0.3);
}

.badge-danger-pill {
    background: rgba(239, 68, 68, 0.2);
    color: #FCA5A5;
    border: 1px solid rgba(239, 68, 68, 0.35);
}

/* Panels */
.panel-card {
    padding: 24px;
}

.settings-section-header {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 20px;
}

.settings-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.header-text-group {
    flex: 1;
}

.header-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 4px;
}

.settings-section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.settings-section-sub {
    font-size: 13px;
    color: var(--text-secondary);
    margin: 0;
}

/* Beta Notice Banner */
.beta-notice-banner {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: rgba(124, 58, 237, 0.08);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-md);
    margin-bottom: 22px;
}

.notice-icon {
    font-size: 18px;
    flex-shrink: 0;
}

.notice-text {
    font-size: 12px;
    color: var(--text-secondary);
    line-height: 1.5;
}

.notice-text strong {
    color: var(--text-primary);
}

/* Toggle List & Items */
.settings-toggle-list {
    display: flex;
    flex-direction: column;
}

.settings-toggle-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid var(--border-subtle);
    gap: 16px;
}

.settings-toggle-item:last-child {
    border-bottom: none;
    padding-bottom: 8px;
}

.toggle-info {
    flex: 1;
}

.toggle-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.toggle-desc {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 3px;
    line-height: 1.4;
}

/* Toggle Switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 26px;
    flex-shrink: 0;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-full);
    transition: all var(--transition-normal);
}

.toggle-slider::before {
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    left: 3px;
    top: 3px;
    background: var(--text-muted);
    border-radius: 50%;
    transition: all var(--transition-normal);
}

.toggle-switch input:checked + .toggle-slider {
    background: var(--color-primary);
    border-color: var(--color-primary);
    box-shadow: 0 0 12px rgba(124, 58, 237, 0.4);
}

.toggle-switch input:checked + .toggle-slider::before {
    transform: translateX(20px);
    background: white;
}

/* Font Size Selector */
.font-size-selector {
    display: flex;
    gap: 8px;
}

.text-size-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    border-radius: var(--radius-md);
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    color: var(--text-secondary);
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.text-size-btn:hover {
    border-color: var(--color-primary);
    color: var(--text-primary);
}

.text-size-btn.active {
    background: rgba(124, 58, 237, 0.25);
    border-color: var(--color-primary-light);
    color: white;
    box-shadow: 0 0 10px rgba(124, 58, 237, 0.3);
}

.size-legend {
    font-size: 10px;
    font-weight: 500;
    color: var(--text-muted);
    margin-top: 2px;
}

/* Form Grid */
.settings-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 8px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
}

.form-input {
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    padding: 10px 14px;
    font-size: 14px;
    font-family: var(--font-family);
    transition: border-color var(--transition-fast);
    width: 100%;
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.2);
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23A78BFA' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
    cursor: pointer;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all var(--transition-fast);
    text-decoration: none;
}

.btn-primary {
    background: var(--gradient-brand);
    color: white;
    box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
}

.btn-primary:hover {
    opacity: 0.92;
    transform: translateY(-1px);
}

.btn-outline-sm {
    padding: 7px 14px;
    font-size: 12px;
    border-radius: var(--radius-sm);
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    color: var(--text-secondary);
}

.btn-outline-sm:hover {
    border-color: var(--color-primary);
    color: var(--text-primary);
}

.btn-danger {
    background: rgba(239, 68, 68, 0.18);
    border: 1px solid rgba(239, 68, 68, 0.35);
    color: var(--color-danger);
}

.btn-danger:hover {
    background: rgba(239, 68, 68, 0.3);
    transform: translateY(-1px);
}

.btn-outline-danger {
    padding: 8px 16px;
    font-size: 13px;
    border-radius: var(--radius-md);
    background: transparent;
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: var(--color-danger);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.btn-outline-danger:hover {
    background: rgba(239, 68, 68, 0.15);
}

.panel-footer-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid var(--border-subtle);
}

/* Data Actions Cards */
.data-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.data-action-card {
    display: flex;
    flex-direction: column;
    padding: 18px;
    border-radius: var(--radius-md);
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    gap: 12px;
}

.data-action-icon {
    font-size: 26px;
}

.data-action-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary);
}

.data-action-desc {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 4px;
    line-height: 1.4;
}

/* Danger Zone */
.danger-zone-card {
    border-color: rgba(239, 68, 68, 0.3);
    background: rgba(239, 68, 68, 0.03);
}

.danger-items-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.danger-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.danger-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.danger-desc {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 4px;
}

/* Responsive */
@media (max-width: 860px) {
    .settings-layout {
        grid-template-columns: 1fr;
    }
    .settings-nav-card {
        position: static;
    }
    .settings-nav-list {
        flex-direction: row;
        overflow-x: auto;
        padding-bottom: 6px;
    }
    .settings-nav-btn {
        flex-shrink: 0;
        width: auto;
    }
    .settings-form-grid, .data-actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // 1. Navigation Tabs between Sections
    const navButtons = document.querySelectorAll('.settings-nav-btn');
    const panels = document.querySelectorAll('.settings-panel');
    const hiddenSectionInput = document.getElementById('hidden-active-section');

    function activateSection(targetId) {
        if (!targetId) return;

        navButtons.forEach(btn => {
            const isActive = btn.dataset.target === targetId;
            btn.classList.toggle('active', isActive);
            btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        panels.forEach(p => {
            if (p.id === targetId) {
                p.style.display = 'block';
                p.classList.add('active');
            } else {
                p.style.display = 'none';
                p.classList.remove('active');
            }
        });

        if (hiddenSectionInput) {
            hiddenSectionInput.value = targetId;
        }

        // Update URL hash smoothly
        if (history.replaceState) {
            history.replaceState(null, '', '#' + targetId.replace('sec-', ''));
        }
    }

    navButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            activateSection(btn.dataset.target);
        });
    });

    // Check URL hash or session section
    const hash = window.location.hash.replace('#', '');
    if (hash && document.getElementById('sec-' + hash)) {
        activateSection('sec-' + hash);
    } else if (hiddenSectionInput && hiddenSectionInput.value) {
        activateSection(hiddenSectionInput.value);
    }

    // 2. Real-time Accessibility Sync (localStorage & DOM classes)
    const highContrastToggle = document.getElementById('a11y-high-contrast-toggle');
    const simplifiedToggle   = document.getElementById('a11y-simplified-toggle');
    const animationsToggle   = document.getElementById('a11y-animations-toggle');
    const clearLangToggle    = document.getElementById('a11y-clear-language-toggle');
    const textSizeBtns       = document.querySelectorAll('.text-size-btn');
    const hiddenTextSize     = document.getElementById('hidden-text-size');

    // Get current stored prefs
    function getStoredPrefs() {
        try {
            return JSON.parse(localStorage.getItem('finnex_a11y') || '{}');
        } catch {
            return {};
        }
    }

    function saveStoredPrefs(prefs) {
        localStorage.setItem('finnex_a11y', JSON.stringify(prefs));
        if (typeof applyPreferences === 'function') {
            applyPreferences(prefs);
        } else {
            // Fallback manual application
            document.body.classList.toggle('a11y-high-contrast', !!prefs.highContrast);
            document.body.classList.toggle('a11y-simplified', !!prefs.simplified);
            document.body.classList.toggle('a11y-no-animations', prefs.animations === false);
            document.body.classList.remove('a11y-large-text', 'a11y-xlarge-text');
            if (prefs.textSize === 'large') document.body.classList.add('a11y-large-text');
            if (prefs.textSize === 'xlarge') document.body.classList.add('a11y-xlarge-text');
        }
    }

    if (highContrastToggle) {
        highContrastToggle.addEventListener('change', (e) => {
            const prefs = getStoredPrefs();
            prefs.highContrast = e.target.checked;
            saveStoredPrefs(prefs);
            showNotificationToast(e.target.checked ? 'Alto contraste activado' : 'Alto contraste desactivado');
        });
    }

    if (simplifiedToggle) {
        simplifiedToggle.addEventListener('change', (e) => {
            const prefs = getStoredPrefs();
            prefs.simplified = e.target.checked;
            saveStoredPrefs(prefs);
            showNotificationToast(e.target.checked ? 'Modo simplificado activado' : 'Modo estándar restaurado');
        });
    }

    if (animationsToggle) {
        animationsToggle.addEventListener('change', (e) => {
            const prefs = getStoredPrefs();
            prefs.animations = !e.target.checked;
            saveStoredPrefs(prefs);
            showNotificationToast(e.target.checked ? 'Animaciones reducidas' : 'Animaciones normales');
        });
    }

    if (clearLangToggle) {
        clearLangToggle.addEventListener('change', (e) => {
            const prefs = getStoredPrefs();
            prefs.clearLanguage = e.target.checked;
            saveStoredPrefs(prefs);
            showNotificationToast(e.target.checked ? 'Lenguaje claro activado' : 'Lenguaje estándar');
        });
    }

    textSizeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const size = btn.dataset.size;
            textSizeBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            if (hiddenTextSize) hiddenTextSize.value = size;

            const prefs = getStoredPrefs();
            prefs.textSize = size;
            saveStoredPrefs(prefs);
            showNotificationToast('Tamaño tipográfico: ' + btn.textContent.trim());
        });
    });

    // Reset A11y
    const resetA11yBtn = document.getElementById('a11y-reset-btn');
    if (resetA11yBtn) {
        resetA11yBtn.addEventListener('click', () => {
            localStorage.removeItem('finnex_a11y');
            if (highContrastToggle) highContrastToggle.checked = false;
            if (simplifiedToggle)   simplifiedToggle.checked = false;
            if (animationsToggle)   animationsToggle.checked = false;
            if (clearLangToggle)    clearLangToggle.checked = false;
            if (hiddenTextSize)     hiddenTextSize.value = 'normal';

            textSizeBtns.forEach(b => b.classList.toggle('active', b.dataset.size === 'normal'));
            document.body.classList.remove(
                'a11y-high-contrast',
                'a11y-large-text',
                'a11y-xlarge-text',
                'a11y-simplified',
                'a11y-no-animations'
            );
            showNotificationToast('Configuración de accesibilidad restablecida a valores por defecto');
        });
    }

    // 3. Speech Assistance Demo Button
    const testSpeechBtn = document.getElementById('btn-test-speech');
    if (testSpeechBtn) {
        testSpeechBtn.addEventListener('click', () => {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const text = "Bienvenido a FINNEX. Tu saldo disponible actual es saludable y las alertas de seguridad están activas.";
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'es-ES';
                utterance.rate = 1.0;
                window.speechSynthesis.speak(utterance);
                showNotificationToast('🔊 Reproduciendo lectura asistida de prueba...');
            } else {
                showNotificationToast('Tu navegador no soporta síntesis de voz nativa.');
            }
        });
    }

    // 4. Test Push Notification Button
    const testNotifBtn = document.getElementById('btn-test-notification');
    if (testNotifBtn) {
        testNotifBtn.addEventListener('click', () => {
            showNotificationToast('🔔 Alerta de prueba FINNEX: Tu presupuesto de entretenimiento está al 80%');
        });
    }

    // 5. Clear FIN-BOT Memory Button
    const clearBotBtn = document.getElementById('btn-clear-bot-cache');
    if (clearBotBtn) {
        clearBotBtn.addEventListener('click', () => {
            showNotificationToast('🧹 Memoria de conversación de FIN-BOT vaciada.');
        });
    }

    // 6. Copy Summary Button
    const copySummaryBtn = document.getElementById('btn-copy-summary');
    if (copySummaryBtn) {
        copySummaryBtn.addEventListener('click', () => {
            const summary = `FINNEX v1.0 Beta - Resumen de Configuración:\nMoneda: ${document.getElementById('setting-currency').value}\nIdioma: ${document.getElementById('setting-language').value}\nTema: ${document.getElementById('setting-theme').value}\nAccesibilidad: Activa`;
            navigator.clipboard.writeText(summary).then(() => {
                showNotificationToast('📋 Resumen de configuración copiado al portapapeles');
            });
        });
    }

    // Helper toast function
    function showNotificationToast(msg) {
        let toast = document.getElementById('finnex-settings-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'finnex-settings-toast';
            toast.style.cssText = `
                position: fixed;
                bottom: 24px;
                right: 24px;
                background: #1A1140;
                border: 1px solid #7C3AED;
                color: #F1F5F9;
                padding: 12px 20px;
                border-radius: 12px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.5);
                font-size: 13px;
                font-weight: 600;
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 10px;
                transition: opacity 0.3s ease, transform 0.3s ease;
            `;
            document.body.appendChild(toast);
        }
        toast.textContent = msg;
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';

        clearTimeout(toast.timer);
        toast.timer = setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
        }, 3200);
    }

});
</script>
@endpush
@endsection
