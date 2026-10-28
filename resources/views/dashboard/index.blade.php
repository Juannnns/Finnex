@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen financiero de octubre 2025')

@section('content')

{{-- Hero Balance Card --}}
<div class="card card-hero animate-fade-up" style="margin-bottom: var(--space-5); position:relative; overflow:hidden;">
    <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;background:rgba(255,255,255,0.05);border-radius:50%;"></div>
    <div style="position:absolute;top:20px;right:80px;width:100px;height:100px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>

    <div class="flex items-center justify-between" style="position:relative;z-index:1;">
        <div>
            <div style="font-size:var(--font-size-sm);font-weight:600;color:rgba(255,255,255,0.7);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">
                Saldo Total Disponible
            </div>
            <div style="font-size:52px;font-weight:900;color:white;letter-spacing:-2px;line-height:1;">
                ${{ number_format($balance, 0, ',', '.') }}
            </div>
            <div style="margin-top:12px;display:flex;align-items:center;gap:12px;">
                <span style="background:rgba(16,185,129,0.25);color:#6EE7B7;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                    ↑ +4.2% vs. mes anterior
                </span>
                <span style="color:rgba(255,255,255,0.6);font-size:13px;">Actualizado ahora</span>
            </div>
        </div>

        <div style="text-align:right;">
            {{-- Health Score Mini --}}
            <div style="background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);border-radius:16px;padding:16px 20px;border:1px solid rgba(255,255,255,0.15);">
                <div style="font-size:11px;color:rgba(255,255,255,0.6);margin-bottom:4px;text-transform:uppercase;letter-spacing:1px;">Salud Financiera</div>
                <div style="font-size:36px;font-weight:900;color:white;line-height:1;">{{ $health_score }}</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.6);">de 100</div>
                <div style="width:80px;height:4px;background:rgba(255,255,255,0.2);border-radius:2px;margin-top:8px;">
                    <div style="width:{{ $health_score }}%;height:100%;background:rgba(255,255,255,0.8);border-radius:2px;transition:width 1s ease;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- KPI Cards Row --}}
<div class="grid grid-cols-4 gap-4" style="margin-bottom:var(--space-5);">

    {{-- Income --}}
    <div class="stat-card income animate-fade-up anim-delay-1">
        <div class="stat-card-header">
            <div>
                <div class="card-title">Ingresos</div>
                <div class="card-value-sm">${{ number_format($income, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card-icon income">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                    <polyline points="17 6 23 6 23 12"/>
                </svg>
            </div>
        </div>
        <span class="card-delta positive">↑ {{ $income_delta }}</span>
    </div>

    {{-- Expenses --}}
    <div class="stat-card expense animate-fade-up anim-delay-2">
        <div class="stat-card-header">
            <div>
                <div class="card-title">Gastos</div>
                <div class="card-value-sm">${{ number_format($expenses, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card-icon expense">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/>
                    <polyline points="17 18 23 18 23 12"/>
                </svg>
            </div>
        </div>
        <span class="card-delta negative">↓ {{ $expenses_delta }}</span>
    </div>

    {{-- Savings --}}
    <div class="stat-card savings animate-fade-up anim-delay-3">
        <div class="stat-card-header">
            <div>
                <div class="card-title">Ahorro</div>
                <div class="card-value-sm">${{ number_format($savings, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card-icon savings">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
            </div>
        </div>
        <span class="card-delta positive">↑ {{ $savings_delta }}</span>
    </div>

    {{-- Goals --}}
    <div class="stat-card goal animate-fade-up anim-delay-4">
        <div class="stat-card-header">
            <div>
                <div class="card-title">Metas</div>
                <div class="card-value-sm">3 activas</div>
            </div>
            <div class="stat-card-icon goal">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                </svg>
            </div>
        </div>
        <div class="progress-container" style="margin-top:8px;">
            <div class="progress-bar-bg">
                <div class="progress-bar-fill brand" data-width="62"></div>
            </div>
        </div>
        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">62% promedio alcanzado</div>
    </div>

</div>

{{-- Main Content Grid --}}
<div class="grid grid-cols-2-3 gap-5" style="margin-bottom:var(--space-5);">

    {{-- Chart --}}
    <div class="card animate-fade-up">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div>
                <div class="section-title" style="margin-bottom:2px;">Flujo financiero</div>
                <div class="text-secondary text-sm">Ingresos vs. gastos — últimos 6 meses</div>
            </div>
            <div style="display:flex;gap:8px;">
                <button class="btn btn-ghost btn-sm">Mensual</button>
                <button class="btn btn-secondary btn-sm">Trimestral</button>
            </div>
        </div>
        <div style="height:240px;">
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>

    {{-- Alerts --}}
    <div class="card animate-fade-up">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div class="section-title" style="margin-bottom:0;">Alertas activas</div>
            <a href="{{ route('finsafe') }}" class="btn btn-ghost btn-sm">Ver todas</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:var(--space-3);">
            @foreach($alerts as $alert)
            <div class="alert-item {{ $alert['level'] }}" onclick="window.location='{{ route('finsafe') }}'">
                <div class="alert-icon">{{ $alert['icon'] }}</div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:var(--font-size-sm);font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $alert['title'] }}</div>
                    <div style="font-size:var(--font-size-xs);color:var(--text-muted);margin-top:2px;">{{ $alert['time'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Bottom Grid: Transactions + Goals --}}
<div class="grid grid-cols-2-3 gap-5">

    {{-- Transactions --}}
    <div class="card animate-fade-up">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div class="section-title" style="margin-bottom:0;">Últimas transacciones</div>
            <a href="{{ route('fin360') }}" class="btn btn-ghost btn-sm">Ver todas</a>
        </div>
        <div class="table-wrapper">
            <table class="finnex-table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Fecha</th>
                        <th style="text-align:right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                    @php
                        $bgColors = [
                            'green' => '16,185,129',
                            'blue' => '96,165,250',
                            'yellow' => '245,158,11',
                            'purple' => '192,132,252',
                            'orange' => '249,115,22'
                        ];
                        $rgb = $bgColors[$tx['color']] ?? '148,163,184';
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div class="transaction-icon" style="background:rgba({{ $rgb }},.15)">
                                    {{ $tx['icon'] }}
                                </div>
                                <span style="font-weight:500;">{{ $tx['desc'] }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-neutral">{{ $tx['category'] }}</span></td>
                        <td class="text-secondary text-sm">{{ $tx['date'] }}</td>
                        <td style="text-align:right;">
                            <span style="font-weight:700;color:{{ $tx['type']==='income' ? 'var(--color-success)' : 'var(--color-danger)' }}">
                                {{ $tx['type']==='income' ? '+' : '' }}${{ number_format(abs($tx['amount']), 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Goals --}}
    <div class="card animate-fade-up">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div class="section-title" style="margin-bottom:0;">Metas financieras</div>
            <a href="{{ route('fin360') }}" class="btn btn-ghost btn-sm">Gestionar</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:var(--space-4);">
            @foreach($goals as $goal)
            @php $pct = round($goal['current']/$goal['target']*100); @endphp
            <div>
                <div class="progress-header">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:18px;">{{ $goal['icon'] }}</span>
                        <span style="font-size:var(--font-size-sm);font-weight:600;">{{ $goal['name'] }}</span>
                    </div>
                    <span style="font-size:var(--font-size-sm);font-weight:700;color:var(--color-primary-light);">{{ $pct }}%</span>
                </div>
                <div class="progress-bar-bg" style="margin-top:8px;">
                    <div class="progress-bar-fill brand" data-width="{{ $pct }}"></div>
                </div>
                <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">
                    ${{ number_format($goal['current'],0,',','.') }} de ${{ number_format($goal['target'],0,',','.') }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
