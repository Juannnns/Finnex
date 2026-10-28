@extends('layouts.app')

@section('title', 'Transferencias')
@section('page-title', 'Transferencias')
@section('page-subtitle', 'Envía dinero de forma segura a otras cuentas Finnex')

@section('content')

{{-- Alertas de éxito / error --}}
@if(session('success'))
<div class="alert-item info animate-fade-up" style="margin-bottom:var(--space-5);padding:16px 20px;border-radius:12px;display:flex;align-items:center;gap:12px;">
    <span style="font-size:22px;">✅</span>
    <span style="font-weight:600;color:var(--text-primary);">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="alert-item high animate-fade-up" style="margin-bottom:var(--space-5);padding:16px 20px;border-radius:12px;">
    <ul style="margin:0;padding-left:20px;color:var(--color-danger);">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-2-3 gap-5" style="margin-bottom:var(--space-5);">

    {{-- ── Formulario de transferencia ─────────────────────────────────── --}}
    <div class="card animate-fade-up">
        <div class="section-title" style="margin-bottom:var(--space-4);">Nueva transferencia</div>

        {{-- Balance actual --}}
        <div class="card card-hero" style="margin-bottom:var(--space-4);padding:20px 24px;border-radius:14px;">
            <div style="font-size:11px;color:rgba(255,255,255,0.65);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">
                Saldo disponible
            </div>
            <div style="font-size:36px;font-weight:900;color:white;letter-spacing:-1px;line-height:1;">
                ${{ $account ? number_format($account->balance, 0, ',', '.') : '0' }}
            </div>
            <div style="font-size:12px;color:rgba(255,255,255,0.55);margin-top:6px;">
                N° Cuenta: {{ $account?->account_number ?? '—' }}
            </div>
        </div>

        <form method="POST" action="{{ route('transfers.send') }}" id="transfer-form">
            @csrf

            {{-- Email destinatario --}}
            <div style="margin-bottom:var(--space-4);">
                <label style="display:block;font-size:var(--font-size-sm);font-weight:600;color:var(--text-secondary);margin-bottom:8px;">
                    Correo del destinatario
                </label>
                <div style="position:relative;">
                    <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--text-muted);" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <input
                        type="email"
                        name="recipient_email"
                        id="recipient_email"
                        placeholder="correo@ejemplo.com"
                        value="{{ old('recipient_email') }}"
                        style="width:100%;padding:12px 14px 12px 42px;background:var(--bg-card-2);border:1px solid var(--border-primary);border-radius:10px;color:var(--text-primary);font-size:var(--font-size-sm);outline:none;box-sizing:border-box;"
                        required
                    >
                </div>
                @error('recipient_email')
                    <div style="color:var(--color-danger);font-size:12px;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Monto --}}
            <div style="margin-bottom:var(--space-4);">
                <label style="display:block;font-size:var(--font-size-sm);font-weight:600;color:var(--text-secondary);margin-bottom:8px;">
                    Monto a transferir
                </label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-weight:700;font-size:16px;">$</span>
                    <input
                        type="number"
                        name="amount"
                        id="amount"
                        placeholder="0"
                        min="1000"
                        step="1000"
                        value="{{ old('amount') }}"
                        style="width:100%;padding:12px 14px 12px 30px;background:var(--bg-card-2);border:1px solid var(--border-primary);border-radius:10px;color:var(--text-primary);font-size:var(--font-size-sm);outline:none;box-sizing:border-box;"
                        required
                    >
                </div>
                <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Monto mínimo: $1.000</div>
                @error('amount')
                    <div style="color:var(--color-danger);font-size:12px;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Descripción --}}
            <div style="margin-bottom:var(--space-5);">
                <label style="display:block;font-size:var(--font-size-sm);font-weight:600;color:var(--text-secondary);margin-bottom:8px;">
                    Descripción <span style="color:var(--text-muted);font-weight:400;">(opcional)</span>
                </label>
                <input
                    type="text"
                    name="description"
                    id="description"
                    placeholder="Ej: Pago cuota apartamento"
                    maxlength="200"
                    value="{{ old('description') }}"
                    style="width:100%;padding:12px 14px;background:var(--bg-card-2);border:1px solid var(--border-primary);border-radius:10px;color:var(--text-primary);font-size:var(--font-size-sm);outline:none;box-sizing:border-box;"
                >
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;padding:14px;font-size:15px;font-weight:700;border-radius:12px;">
                💸 Enviar transferencia
            </button>
        </form>
    </div>

    {{-- ── Historial de transferencias ──────────────────────────────────── --}}
    <div class="card animate-fade-up anim-delay-1">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div class="section-title" style="margin-bottom:0;">Historial de transferencias</div>
        </div>

        @if($transfers->isEmpty())
        <div style="text-align:center;padding:60px 20px;color:var(--text-muted);">
            <div style="font-size:48px;margin-bottom:12px;">💸</div>
            <div style="font-size:var(--font-size-sm);font-weight:600;">Sin transferencias aún</div>
            <div style="font-size:var(--font-size-xs);margin-top:4px;">Tus transferencias enviadas y recibidas aparecerán aquí.</div>
        </div>
        @else
        <div class="table-wrapper">
            <table class="finnex-table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th style="text-align:right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transfers as $tx)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="transaction-icon" style="background:rgba({{ $tx->type === 'transfer_in' ? '16,185,129' : '96,165,250' }},.15)">
                                    {{ $tx->icon }}
                                </div>
                                <span style="font-weight:500;">{{ $tx->description }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $tx->type === 'transfer_in' ? 'badge-success' : 'badge-neutral' }}">
                                {{ $tx->typeLabel() }}
                            </span>
                        </td>
                        <td class="text-secondary text-sm">{{ $tx->transacted_at->format('d/m/Y H:i') }}</td>
                        <td style="text-align:right;">
                            <span style="font-weight:700;color:{{ $tx->isCredit() ? 'var(--color-success)' : 'var(--color-danger)' }}">
                                {{ $tx->isCredit() ? '+' : '-' }}${{ number_format($tx->amount, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

{{-- ── Info de la otra cuenta (para facilitar las pruebas) ─────────── --}}
<div class="card animate-fade-up" style="border:1px dashed var(--border-primary);background:var(--bg-card-2);">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
        <span style="font-size:20px;">ℹ️</span>
        <div class="section-title" style="margin-bottom:0;">Cuentas disponibles para transferir</div>
    </div>
    <div style="display:flex;gap:var(--space-4);flex-wrap:wrap;">
        @php
            $allUsers = \App\Models\User::with('account')->where('id', '!=', $user->id)->get();
        @endphp
        @foreach($allUsers as $u)
        @if($u->account)
        <div style="background:var(--bg-surface);border:1px solid var(--border-primary);border-radius:12px;padding:16px 20px;min-width:220px;">
            <div style="font-weight:700;color:var(--text-primary);margin-bottom:4px;">{{ $u->name }}</div>
            <div style="font-size:var(--font-size-xs);color:var(--text-muted);margin-bottom:8px;">{{ $u->email }}</div>
            <div style="font-size:var(--font-size-xs);color:var(--text-secondary);">N° {{ $u->account->account_number }}</div>
            <button
                onclick="document.getElementById('recipient_email').value='{{ $u->email }}'; document.getElementById('recipient_email').focus();"
                class="btn btn-ghost btn-sm"
                style="margin-top:10px;width:100%;"
            >
                Seleccionar destinatario
            </button>
        </div>
        @endif
        @endforeach
    </div>
</div>

@endsection
