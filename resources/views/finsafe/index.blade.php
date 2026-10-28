@extends('layouts.app')

@section('title', 'FIN-SAFE')
@section('page-title', 'FIN-SAFE')
@section('page-subtitle', 'Centro de seguridad y prevención')

@section('content')

{{-- Security Score & Status --}}
<div class="grid gap-5 animate-fade-up" style="grid-template-columns: 320px 1fr; margin-bottom:var(--space-5);">

    {{-- Score Card --}}
    <div class="card" style="display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;">
        <div class="section-title" style="margin-bottom:var(--space-4);">Nivel de Seguridad</div>

        <div class="security-score-ring" style="margin-bottom:var(--space-3);">
            <svg width="140" height="140" viewBox="0 0 140 140" style="transform:rotate(-90deg);">
                <circle cx="70" cy="70" r="60" fill="none" stroke="rgba(167,139,250,0.1)" stroke-width="10"/>
                <circle cx="70" cy="70" r="60" fill="none" stroke="var(--color-{{ $security_color }})" stroke-width="10"
                        stroke-dasharray="377" stroke-dashoffset="{{ 377 - (377 * $security_score / 100) }}" stroke-linecap="round"
                        style="transition:stroke-dashoffset 1.5s ease;"/>
            </svg>
            <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                <div style="font-size:32px;font-weight:800;color:var(--text-primary);line-height:1;">{{ $security_score }}</div>
                <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">de 100</div>
            </div>
        </div>

        <span class="badge badge-{{ $security_color }}">{{ $security_level }}</span>
        <p style="font-size:var(--font-size-xs);color:var(--text-muted);margin-top:var(--space-3);line-height:1.5;">
            Tu cuenta está bien protegida. Mantén actualizadas tus contraseñas y dispositivos.
        </p>
    </div>

    {{-- Active Alerts --}}
    <div class="card">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div>
                <div class="section-title" style="margin-bottom:2px;">Alertas de Seguridad</div>
                <div class="text-secondary text-sm">Requieren tu atención</div>
            </div>
            @if(count($alerts) > 0)
                <span class="badge badge-danger">{{ count(array_filter($alerts, fn($a)=>$a['status']==='pending')) }} pendientes</span>
            @endif
        </div>

        <div style="display:flex;flex-direction:column;gap:var(--space-3);">
            @forelse($alerts as $alert)
            <div class="alert-item {{ $alert['level'] }}" style="opacity:{{ $alert['status']==='resolved'?'0.6':'1' }};" id="alert-{{ $alert['id'] }}">
                <div class="alert-icon">{{ $alert['icon'] }}</div>
                <div style="flex:1;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                        <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--text-primary);">{{ $alert['title'] }}</span>
                        <span style="font-size:var(--font-size-xs);color:var(--text-muted);">{{ $alert['time'] }}</span>
                    </div>
                    <p style="font-size:var(--font-size-xs);color:var(--text-secondary);line-height:1.5;margin-bottom:12px;">{{ $alert['desc'] }}</p>

                    @if($alert['status'] === 'pending')
                    <div style="display:flex;gap:12px;">
                        <button class="btn btn-primary btn-sm" onclick="openAlertDetail({{ json_encode($alert) }})">Ver detalles</button>
                        <button class="btn btn-ghost btn-sm" onclick="dismissAlert({{ $alert['id'] }})">Reconocer y ocultar</button>
                    </div>
                    @else
                    <span class="badge badge-neutral" style="font-size:10px;">Revisada</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <span style="font-size:32px;display:block;margin-bottom:12px;">🛡️</span>
                No hay alertas de seguridad pendientes.<br>Todo está en orden.
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- Transactions & Devices --}}
<div class="grid grid-cols-2 gap-5 animate-fade-up anim-delay-1">

    {{-- Suspicious Transactions --}}
    <div class="card">
        <div class="section-title" style="margin-bottom:var(--space-4);">Análisis de Fraude (Simulado)</div>
        <div class="table-wrapper">
            <table class="finnex-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Comercio</th>
                        <th>Riesgo</th>
                        <th style="text-align:right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suspicious_transactions as $tx)
                    <tr>
                        <td class="text-secondary text-sm">{{ $tx['date'] }}</td>
                        <td>
                            <div style="font-weight:500;">{{ $tx['merchant'] }}</div>
                            <div style="font-size:10px;color:var(--text-muted);">{{ $tx['reason'] }}</div>
                        </td>
                        <td>
                            @php
                                $rBadge = $tx['risk'] === 'high' ? 'danger' : ($tx['risk'] === 'medium' ? 'warning' : 'info');
                                $rLabel = $tx['risk'] === 'high' ? 'Alto' : ($tx['risk'] === 'medium' ? 'Medio' : 'Bajo');
                            @endphp
                            <span class="badge badge-{{ $rBadge }}">{{ $rLabel }}</span>
                        </td>
                        <td style="text-align:right;font-weight:600;color:var(--text-primary);">
                            ${{ number_format($tx['amount'],0,',','.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Devices --}}
    <div class="card">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div class="section-title" style="margin-bottom:0;">Dispositivos Recientes</div>
            <button class="btn btn-ghost btn-sm">Cerrar todas las sesiones</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:var(--space-3);">
            @foreach($devices as $dev)
            <div class="device-item">
                <div class="device-status-dot {{ $dev['active'] ? 'active' : 'inactive' }}"></div>
                <div style="flex:1;">
                    <div style="font-size:var(--font-size-sm);font-weight:600;color:var(--text-primary);">{{ $dev['name'] }}</div>
                    <div style="font-size:var(--font-size-xs);color:var(--text-muted);">{{ $dev['os'] }} · {{ $dev['location'] }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:var(--font-size-xs);color:var(--text-secondary);">{{ $dev['time'] }}</div>
                    @if(!$dev['active'])
                    <button class="btn btn-ghost" style="padding:2px 8px;font-size:10px;margin-top:4px;">Desvincular</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Recommendations --}}
<div class="card animate-fade-up anim-delay-2" style="margin-top:var(--space-5);">
    <div class="section-title" style="margin-bottom:var(--space-4);">Recomendaciones de Seguridad</div>
    <div class="grid grid-cols-2 gap-4">
        @foreach($recommendations as $rec)
        <div style="display:flex;gap:var(--space-3);padding:var(--space-4);background:rgba(255,255,255,0.02);border:1px solid var(--border-subtle);border-radius:var(--radius-md);">
            <div style="font-size:24px;opacity:{{ $rec['done'] ? '0.5' : '1' }};">{{ $rec['icon'] }}</div>
            <div>
                <div style="font-size:var(--font-size-sm);font-weight:600;color:{{ $rec['done'] ? 'var(--text-secondary)' : 'var(--text-primary)' }};margin-bottom:4px;">
                    {{ $rec['title'] }}
                </div>
                <div style="font-size:var(--font-size-xs);color:var(--text-muted);margin-bottom:8px;">{{ $rec['desc'] }}</div>
                @if(!$rec['done'])
                    <button class="btn btn-ghost btn-sm" style="padding:4px 10px;font-size:11px;">Configurar ahora</button>
                @else
                    <span class="badge badge-success" style="font-size:10px;">✓ Completado</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('modals')
{{-- Alert Detail Modal --}}
<div class="modal-overlay" id="alert-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" style="display:flex;align-items:center;gap:8px;">
                <span id="modal-icon">⚠️</span> Detalles de la Alerta
            </div>
            <button class="modal-close" onclick="closeModal('alert-modal')">×</button>
        </div>
        
        <div id="modal-content" style="margin-bottom:var(--space-5);">
            <!-- Dynamic content injected via JS -->
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
            <button class="btn btn-ghost" onclick="closeModal('alert-modal')">Cerrar</button>
            <button class="btn btn-danger" onclick="alert('Esta función reportaría el fraude en una app real.'); closeModal('alert-modal');">Reportar problema</button>
            <button class="btn btn-primary" onclick="closeModal('alert-modal'); if(window.showToast) showToast('Transacción reconocida exitosamente', 'success');">Sí, fui yo</button>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
function openAlertDetail(alertData) {
    document.getElementById('modal-icon').textContent = alertData.icon;
    
    let detailHtml = `
        <div style="font-weight:600;color:var(--text-primary);font-size:15px;margin-bottom:8px;">${alertData.title}</div>
        <p style="font-size:13px;color:var(--text-secondary);margin-bottom:16px;">${alertData.desc}</p>
        
        <div style="background:var(--bg-base);border:1px solid var(--border-subtle);border-radius:8px;padding:12px;">
            <div style="font-size:11px;text-transform:uppercase;color:var(--text-muted);font-weight:700;margin-bottom:8px;letter-spacing:1px;">Datos técnicos</div>
    `;
    
    for (const [key, value] of Object.entries(alertData.detail)) {
        let displayVal = value;
        if (key === 'amount') displayVal = new Intl.NumberFormat('es-CL', {style:'currency',currency:'CLP',minimumFractionDigits:0}).format(value);
        
        detailHtml += `
            <div style="display:flex;justify-content:space-between;padding:4px 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                <span style="color:var(--text-secondary);font-size:12px;text-transform:capitalize;">${key}</span>
                <span style="color:var(--text-primary);font-size:12px;font-weight:500;">${displayVal}</span>
            </div>
        `;
    }
    
    detailHtml += `</div>`;
    
    document.getElementById('modal-content').innerHTML = detailHtml;
    openModal('alert-modal');
}

function dismissAlert(id) {
    const el = document.getElementById('alert-' + id);
    if (!el) return;
    
    // Animate out
    el.style.transform = 'translateX(100px)';
    el.style.opacity = '0';
    
    setTimeout(() => {
        el.remove();
        if (window.showToast) showToast('Alerta descartada', 'success');
        
        // Check if empty
        const remaining = document.querySelectorAll('.alert-item').length;
        if (remaining === 0) {
            // Optional: Show empty state via JS or let reload handle it
            location.reload(); 
        }
    }, 300);
}
</script>
@endpush
