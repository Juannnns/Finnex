@extends('layouts.app')

@section('title', 'FIN-360')
@section('page-title', 'FIN-360')
@section('page-subtitle', 'Análisis y organización financiera completa')

@section('content')

{{-- Page Header --}}
<div class="page-header animate-fade-up">
    <div class="page-header-text">
        <h1>Análisis Financiero <span class="gradient-text">360°</span></h1>
        <p>Visión completa de tus ingresos, gastos, ahorro y metas — octubre 2025</p>
    </div>
    <a href="{{ route('finbot') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        Pedir consejo a FIN-BOT
    </a>
</div>

{{-- Metric Cards --}}
<div class="grid grid-cols-4 gap-4 animate-fade-up" style="margin-bottom:var(--space-5);">
    @php
        $metrics = [
            ['label'=>'Ingresos', 'value'=>$income, 'icon'=>'📈', 'class'=>'income', 'delta'=>'+4.9%', 'positive'=>true],
            ['label'=>'Gastos', 'value'=>$expenses, 'icon'=>'📉', 'class'=>'expense', 'delta'=>'-2.1%', 'positive'=>false],
            ['label'=>'Ahorro Neto', 'value'=>$savings, 'icon'=>'💰', 'class'=>'savings', 'delta'=>'+8.3%', 'positive'=>true],
            ['label'=>'Obligaciones', 'value'=>$obligations, 'icon'=>'🏠', 'class'=>'goal', 'delta'=>'Estable', 'positive'=>null],
        ];
    @endphp
    @foreach($metrics as $m)
    <div class="stat-card {{ $m['class'] }}">
        <div class="stat-card-header">
            <div>
                <div class="card-title">{{ $m['label'] }}</div>
                <div class="card-value-sm">${{ number_format($m['value'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-card-icon {{ $m['class'] }}" style="font-size:20px;">{{ $m['icon'] }}</div>
        </div>
        <span class="card-delta {{ $m['positive']===true ? 'positive' : ($m['positive']===false ? 'negative' : 'neutral') }}">
            {{ $m['positive']===true ? '↑' : ($m['positive']===false ? '↓' : '→') }} {{ $m['delta'] }}
        </span>
    </div>
    @endforeach
</div>

{{-- Health Score + Donut --}}
<div class="grid gap-5 animate-fade-up" style="grid-template-columns:1fr 2fr;margin-bottom:var(--space-5);">

    {{-- Health Score --}}
    <div class="card" style="display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:var(--space-4);">
        <div>
            <div class="section-title">Salud Financiera</div>
            <div class="text-secondary text-sm">Puntaje de bienestar financiero</div>
        </div>

        <div class="health-score-circle" style="width:160px;height:160px;">
            <svg width="160" height="160" viewBox="0 0 160 160">
                <circle cx="80" cy="80" r="67" fill="none" stroke="rgba(167,139,250,0.1)" stroke-width="12"/>
                <circle
                    id="health-circle"
                    cx="80" cy="80" r="67"
                    fill="none"
                    stroke="url(#health-grad)"
                    stroke-width="12"
                    stroke-linecap="round"
                    data-score="{{ $health_score }}"
                />
                <defs>
                    <linearGradient id="health-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#7C3AED"/>
                        <stop offset="100%" stop-color="#60A5FA"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="health-score-text">
                <div class="health-score-number gradient-text">{{ $health_score }}</div>
                <div class="health-score-label">de 100</div>
            </div>
        </div>

        <div style="width:100%;">
            @php
                $scoreLabel = $health_score >= 90 ? ['Excelente','success'] : ($health_score >= 75 ? ['Muy buena','info'] : ($health_score >= 60 ? ['Buena','warning'] : ['Por mejorar','danger']));
            @endphp
            <span class="badge badge-{{ $scoreLabel[1] }}" style="font-size:13px;padding:6px 16px;">{{ $scoreLabel[0] }}</span>
            <p class="text-secondary text-sm" style="margin-top:12px;line-height:1.5;">
                Tu perfil financiero es sólido. Mejorar tu fondo de emergencia impactaría positivamente tu score.
            </p>
        </div>
    </div>

    {{-- Donut Chart --}}
    <div class="card">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div>
                <div class="section-title" style="margin-bottom:2px;">Distribución de gastos</div>
                <div class="text-secondary text-sm">Por categoría — octubre 2025</div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:center;">
            <div style="height:260px;">
                <canvas id="fin360DonutChart"></canvas>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($expense_categories as $cat)
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:10px;height:10px;border-radius:3px;background:{{ $cat['color'] }};flex-shrink:0;"></div>
                        <span style="font-size:13px;color:var(--text-secondary);">{{ $cat['name'] }}</span>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);">${{ number_format($cat['amount'],0,',','.') }}</div>
                        <div style="font-size:11px;color:var(--text-muted);">{{ $cat['percent'] }}%</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- Savings Trend Chart --}}
<div class="card animate-fade-up" style="margin-bottom:var(--space-5);">
    <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
        <div>
            <div class="section-title" style="margin-bottom:2px;">Tendencia de ahorro</div>
            <div class="text-secondary text-sm">Ahorro mensual vs. meta — últimos 9 meses</div>
        </div>
        <span class="badge badge-success">📈 Tendencia positiva</span>
    </div>
    <div style="height:220px;">
        <canvas id="fin360TrendChart"></canvas>
    </div>
</div>

{{-- Goals + Recommendations --}}
<div class="grid grid-cols-2 gap-5 animate-fade-up">

    {{-- Goals --}}
    <div class="card">
        <div class="flex items-center justify-between" style="margin-bottom:var(--space-4);">
            <div class="section-title" style="margin-bottom:0;">Metas financieras</div>
            <button class="btn btn-secondary btn-sm">+ Nueva meta</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:var(--space-5);">
            @foreach($goals as $goal)
            @php $pct = round($goal['current']/$goal['target']*100); @endphp
            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:var(--space-2);">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:22px;">{{ $goal['icon'] }}</span>
                        <div>
                            <div style="font-size:var(--font-size-sm);font-weight:600;color:var(--text-primary);">{{ $goal['name'] }}</div>
                            <div style="font-size:11px;color:var(--text-muted);">Aporte mensual: ${{ number_format($goal['monthly'],0,',','.') }} · Meta: {{ $goal['deadline'] }}</div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:var(--font-size-lg);font-weight:800;color:var(--color-primary-light);">{{ $pct }}%</div>
                    </div>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill {{ $pct >= 70 ? 'brand' : ($pct >= 40 ? 'income' : 'warning') }}" data-width="{{ $pct }}"></div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:6px;font-size:11px;color:var(--text-muted);">
                    <span>${{ number_format($goal['current'],0,',','.') }}</span>
                    <span>${{ number_format($goal['target'],0,',','.') }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Recommendations --}}
    <div class="card">
        <div class="section-title" style="margin-bottom:var(--space-4);">Recomendaciones FIN-BOT</div>
        <div style="display:flex;flex-direction:column;gap:var(--space-3);">
            @foreach($recommendations as $rec)
            @php
                $badgeClass = $rec['level'] === 'success' ? 'badge-success' : ($rec['level'] === 'warning' ? 'badge-warning' : ($rec['level'] === 'info' ? 'badge-info' : 'badge-purple'));
            @endphp
            <div style="display:flex;gap:var(--space-3);padding:var(--space-3) var(--space-4);background:var(--bg-card);border-radius:var(--radius-md);border:1px solid var(--border-subtle);transition:border-color var(--transition-fast);" onmouseover="this.style.borderColor='var(--border-medium)'" onmouseout="this.style.borderColor='var(--border-subtle)'">
                <div style="font-size:22px;flex-shrink:0;margin-top:2px;">{{ $rec['icon'] }}</div>
                <div style="flex:1;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                        <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--text-primary);">{{ $rec['title'] }}</span>
                        <span class="badge {{ $badgeClass }}" style="font-size:10px;">{{ $rec['impact'] }}</span>
                    </div>
                    <p style="font-size:var(--font-size-xs);color:var(--text-secondary);line-height:1.5;">{{ $rec['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('finbot') }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:var(--space-4);">
            Consultar a FIN-BOT sobre mis finanzas
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script>
window.fin360Categories = @json($expense_categories);

// Health Score Circle Animation
document.addEventListener('DOMContentLoaded', () => {
    const circle = document.getElementById('health-circle');
    if (circle) {
        const score = parseInt(circle.dataset.score);
        const radius = 67;
        const circumference = 2 * Math.PI * radius;
        circle.style.strokeDasharray = circumference;
        circle.style.strokeDashoffset = circumference;
        setTimeout(() => {
            circle.style.transition = 'stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
            circle.style.strokeDashoffset = circumference - (score / 100) * circumference;
        }, 400);
    }
});
</script>
@endpush
