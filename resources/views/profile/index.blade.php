@extends('layouts.app')

@section('title', 'Perfil')
@section('page-title', 'Mi Perfil')
@section('page-subtitle', 'Gestiona tu información personal')

@section('content')
<div class="animate-fade-up" style="max-width: 860px;">

    {{-- Alerts --}}
    @if(session('success_info'))
        <div class="alert-banner alert-success" id="alert-success-info">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success_info') }}
        </div>
    @endif
    @if(session('success_password'))
        <div class="alert-banner alert-success" id="alert-success-pwd">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success_password') }}
        </div>
    @endif

    {{-- Profile Header Card --}}
    <div class="card card-gradient" style="margin-bottom: 24px; display:flex; align-items:center; gap: 24px; padding: 32px;">
        <div class="profile-avatar-lg">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div style="flex:1">
            <div style="font-size: 22px; font-weight: 800; color: var(--text-primary);">{{ $user->name }}</div>
            <div style="color: var(--text-secondary); font-size: 14px; margin-top: 4px;">{{ $user->email }}</div>
            <div style="margin-top: 10px; display:flex; gap: 8px; flex-wrap: wrap;">
                <span class="role-badge">{{ $user->role }}</span>
                @if(!empty($user->phone))
                    <span class="role-badge role-badge-secondary">📞 {{ $user->phone }}</span>
                @endif
            </div>
        </div>
        <div style="text-align: right; color: var(--text-muted); font-size: 12px;">
            <div>Miembro desde</div>
            <div style="font-weight: 600; color: var(--text-secondary); margin-top: 4px;">
                {{ $user->created_at ? $user->created_at->format('M Y') : 'Octubre 2026' }}
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

        {{-- Personal Info Form --}}
        <div class="card" style="grid-column: 1 / -1;">
            <div class="card-header-row">
                <div>
                    <div class="card-title">Información Personal</div>
                    <div class="card-subtitle">Actualiza tu nombre, correo y datos de contacto</div>
                </div>
            </div>

            @if($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('bio'))
                <div class="alert-banner alert-danger" style="margin-bottom: 16px;">
                    @foreach($errors->only(['name','email','phone','bio']) as $e)
                        <div>{{ $e }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update.info') }}" id="form-profile-info">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label" for="profile-name">Nombre completo</label>
                        <input class="form-input @error('name') input-error @enderror"
                               id="profile-name" name="name" type="text"
                               value="{{ old('name', $user->name) }}" placeholder="Tu nombre">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="profile-email">Correo electrónico</label>
                        <input class="form-input @error('email') input-error @enderror"
                               id="profile-email" name="email" type="email"
                               value="{{ old('email', $user->email) }}" placeholder="tu@correo.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="profile-phone">Teléfono <span style="color:var(--text-muted)">(opcional)</span></label>
                        <input class="form-input"
                               id="profile-phone" name="phone" type="tel"
                               value="{{ old('phone', $user->phone ?? '') }}" placeholder="+57 300 000 0000">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label" for="profile-bio">Bio <span style="color:var(--text-muted)">(opcional, max. 300 chars)</span></label>
                        <textarea class="form-input" id="profile-bio" name="bio"
                                  rows="3" placeholder="Cuéntanos algo sobre ti..."
                                  style="resize: vertical;">{{ old('bio', $user->bio ?? '') }}</textarea>
                    </div>
                </div>
                <div style="margin-top: 20px; display:flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btn-save-profile">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="card" style="grid-column: 1 / -1;">
            <div class="card-header-row">
                <div>
                    <div class="card-title">Cambiar Contraseña</div>
                    <div class="card-subtitle">Asegúrate de usar una contraseña segura</div>
                </div>
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary-light)" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>

            @error('current_password')
                <div class="alert-banner alert-danger" style="margin-bottom: 16px;">{{ $message }}</div>
            @enderror
            @error('new_password')
                <div class="alert-banner alert-danger" style="margin-bottom: 16px;">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('profile.update.password') }}" id="form-profile-password">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label" for="current-password">Contraseña actual</label>
                        <input class="form-input @error('current_password') input-error @enderror"
                               id="current-password" name="current_password"
                               type="password" placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="new-password">Nueva contraseña</label>
                        <input class="form-input @error('new_password') input-error @enderror"
                               id="new-password" name="new_password"
                               type="password" placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="confirm-password">Confirmar contraseña</label>
                        <input class="form-input"
                               id="confirm-password" name="new_password_confirmation"
                               type="password" placeholder="••••••••">
                    </div>
                </div>
                <div style="margin-top: 20px; display:flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btn-save-password">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Actualizar contraseña
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@push('styles')
<style>
.profile-avatar-lg {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: var(--gradient-brand);
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; font-weight: 800; color: white;
    flex-shrink: 0;
    box-shadow: 0 0 30px rgba(124,58,237,0.5);
}
.role-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 12px;
    background: rgba(124,58,237,0.15);
    border: 1px solid rgba(124,58,237,0.3);
    border-radius: var(--radius-full);
    font-size: 12px; font-weight: 600;
    color: var(--color-primary-light);
}
.role-badge-secondary {
    background: rgba(96,165,250,0.1);
    border-color: rgba(96,165,250,0.3);
    color: var(--color-accent-blue);
}
.card-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 24px;
}
.card-title { font-size: 16px; font-weight: 700; color: var(--text-primary); }
.card-subtitle { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-label { font-size: 13px; font-weight: 600; color: var(--text-secondary); }
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
.form-input:focus { outline: none; border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(124,58,237,0.15); }
.input-error { border-color: var(--color-danger) !important; }
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: all var(--transition-fast); }
.btn-primary { background: var(--gradient-brand); color: white; box-shadow: 0 4px 15px rgba(124,58,237,0.4); }
.btn-primary:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(124,58,237,0.5); }
.alert-banner { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: var(--radius-md); font-size: 13px; font-weight: 500; margin-bottom: 20px; }
.alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: var(--color-success); }
.alert-danger  { background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.3);  color: var(--color-danger); flex-direction: column; align-items: flex-start; }
</style>
@endpush
@endsection
