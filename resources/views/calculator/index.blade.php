@extends('layouts.app')

@section('title', 'FIN-CALCULATOR — Herramientas Financieras')
@section('page-title', 'FIN-CALCULATOR')
@section('page-subtitle', 'Calculadoras y simuladores financieros')

@section('content')

{{-- Tab Navigation --}}
<div class="fe-tab-bar animate-fade-up">
    <button class="fe-tab active" data-tab="budget"   id="tab-budget">   📊 Presupuesto 50/30/20</button>
    <button class="fe-tab"        data-tab="compound" id="tab-compound"> 📈 Interés Compuesto</button>
    <button class="fe-tab"        data-tab="loan"     id="tab-loan">     🏠 Crédito / Hipoteca</button>
    <button class="fe-tab"        data-tab="debt"     id="tab-debt">     💳 Liquidar Deuda</button>
    <button class="fe-tab"        data-tab="goal"     id="tab-goal">     🎯 Meta de Ahorro</button>
    <button class="fe-tab"        data-tab="inflation"id="tab-inflation"> 📉 Inflación</button>
    <button class="fe-tab"        data-tab="currency" id="tab-currency"> 🔄 Divisas</button>
</div>

{{-- ===== 1. PRESUPUESTO 50/30/20 ===== --}}
<div class="fe-panel active animate-fade-up" id="panel-budget">
    <div class="fe-panel-header">
        <div class="fe-panel-icon" style="background:rgba(124,58,237,0.2);">📊</div>
        <div>
            <div class="fe-panel-title">Regla del 50/30/20</div>
            <div class="fe-panel-sub">Divide tu ingreso neto en necesidades, deseos y ahorro de forma óptima</div>
        </div>
    </div>
    <div class="fe-grid-2">
        <div>
            <div class="fe-input-group">
                <label class="fe-label" for="budget-income">💰 Ingreso mensual neto</label>
                <div class="fe-input-prefix">
                    <span class="fe-prefix">$</span>
                    <input class="fe-input" id="budget-income" type="number" min="0" placeholder="25000" oninput="calcBudget()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="budget-currency">Moneda</label>
                <select class="fe-input fe-select" id="budget-currency" onchange="calcBudget()">
                    <option value="MXN">MXN — Peso Mexicano</option>
                    <option value="USD">USD — Dólar</option>
                    <option value="EUR">EUR — Euro</option>
                </select>
            </div>
            <div class="fe-info-box">
                <strong>¿Cómo funciona?</strong><br>
                Esta regla, popularizada por Elizabeth Warren, divide el ingreso neto en tres categorías:
                <ul style="margin:8px 0 0 16px;line-height:1.8;">
                    <li><strong>50% — Necesidades:</strong> renta, servicios, comida, transporte</li>
                    <li><strong>30% — Deseos:</strong> entretenimiento, salidas, suscripciones</li>
                    <li><strong>20% — Ahorro/Deudas:</strong> fondo de emergencia, inversión, deudas</li>
                </ul>
            </div>
        </div>
        <div id="budget-result" class="fe-result-area">
            <div class="fe-result-empty">Ingresa tu ingreso mensual para ver la distribución</div>
        </div>
    </div>
</div>

{{-- ===== 2. INTERÉS COMPUESTO ===== --}}
<div class="fe-panel" id="panel-compound">
    <div class="fe-panel-header">
        <div class="fe-panel-icon" style="background:rgba(16,185,129,0.2);">📈</div>
        <div>
            <div class="fe-panel-title">Simulador de Interés Compuesto</div>
            <div class="fe-panel-sub">Visualiza cómo crece tu dinero con el tiempo y las aportaciones regulares</div>
        </div>
    </div>
    <div class="fe-grid-2">
        <div>
            <div class="fe-input-group">
                <label class="fe-label" for="ci-initial">Capital inicial</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="ci-initial" type="number" min="0" placeholder="10000" oninput="calcCompound()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="ci-monthly">Aportación mensual</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="ci-monthly" type="number" min="0" placeholder="1000" oninput="calcCompound()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="ci-rate">Tasa de rendimiento anual (%)</label>
                <div class="fe-input-prefix"><span class="fe-prefix">%</span>
                    <input class="fe-input" id="ci-rate" type="number" min="0" max="100" step="0.1" placeholder="8" oninput="calcCompound()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="ci-years">Plazo (años)</label>
                <input class="fe-input" id="ci-years" type="number" min="1" max="50" placeholder="10" oninput="calcCompound()">
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="ci-freq">Capitalización</label>
                <select class="fe-input fe-select" id="ci-freq" onchange="calcCompound()">
                    <option value="12">Mensual</option>
                    <option value="4">Trimestral</option>
                    <option value="2">Semestral</option>
                    <option value="1">Anual</option>
                </select>
            </div>
        </div>
        <div id="compound-result" class="fe-result-area">
            <div class="fe-result-empty">Completa los campos para ver la proyección</div>
        </div>
    </div>
    <canvas id="compound-chart" style="max-height:220px;margin-top:16px;display:none;"></canvas>
</div>

{{-- ===== 3. CRÉDITO / HIPOTECA ===== --}}
<div class="fe-panel" id="panel-loan">
    <div class="fe-panel-header">
        <div class="fe-panel-icon" style="background:rgba(96,165,250,0.2);">🏠</div>
        <div>
            <div class="fe-panel-title">Calculadora de Crédito / Hipoteca</div>
            <div class="fe-panel-sub">Calcula cuotas mensuales, intereses totales y tabla de amortización</div>
        </div>
    </div>
    <div class="fe-grid-2">
        <div>
            <div class="fe-input-group">
                <label class="fe-label" for="loan-amount">Monto del préstamo</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="loan-amount" type="number" min="0" placeholder="500000" oninput="calcLoan()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="loan-rate">Tasa de interés anual (%)</label>
                <div class="fe-input-prefix"><span class="fe-prefix">%</span>
                    <input class="fe-input" id="loan-rate" type="number" min="0" max="100" step="0.1" placeholder="12" oninput="calcLoan()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="loan-years">Plazo</label>
                <div style="display:flex;gap:8px;">
                    <input class="fe-input" id="loan-years" type="number" min="1" max="40" placeholder="20" oninput="calcLoan()" style="flex:2;">
                    <select class="fe-input fe-select" id="loan-period" onchange="calcLoan()" style="flex:1;">
                        <option value="years">años</option>
                        <option value="months">meses</option>
                    </select>
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="loan-down">Enganche / pago inicial</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="loan-down" type="number" min="0" placeholder="0" oninput="calcLoan()">
                </div>
            </div>
        </div>
        <div id="loan-result" class="fe-result-area">
            <div class="fe-result-empty">Completa los datos del préstamo</div>
        </div>
    </div>
    <div id="loan-amort" style="display:none;margin-top:16px;">
        <div style="font-size:13px;font-weight:700;color:var(--text-secondary);margin-bottom:8px;">Primeros 12 meses de amortización</div>
        <div style="overflow-x:auto;">
            <table class="fe-table" id="loan-table"></table>
        </div>
    </div>
</div>

{{-- ===== 4. LIQUIDAR DEUDA ===== --}}
<div class="fe-panel" id="panel-debt">
    <div class="fe-panel-header">
        <div class="fe-panel-icon" style="background:rgba(239,68,68,0.2);">💳</div>
        <div>
            <div class="fe-panel-title">¿Cuándo liquido mi deuda?</div>
            <div class="fe-panel-sub">Calcula meses para quedar libre y compara estrategias de pago</div>
        </div>
    </div>
    <div class="fe-grid-2">
        <div>
            <div class="fe-input-group">
                <label class="fe-label" for="debt-balance">Saldo actual de la deuda</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="debt-balance" type="number" min="0" placeholder="15000" oninput="calcDebt()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="debt-rate">Tasa de interés mensual (%)</label>
                <div class="fe-input-prefix"><span class="fe-prefix">%</span>
                    <input class="fe-input" id="debt-rate" type="number" min="0" max="100" step="0.1" placeholder="3.5" oninput="calcDebt()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="debt-min">Pago mínimo mensual</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="debt-min" type="number" min="0" placeholder="500" oninput="calcDebt()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="debt-extra">Pago adicional mensual (opcional)</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="debt-extra" type="number" min="0" placeholder="0" oninput="calcDebt()">
                </div>
            </div>
        </div>
        <div id="debt-result" class="fe-result-area">
            <div class="fe-result-empty">Ingresa los datos de tu deuda</div>
        </div>
    </div>
</div>

{{-- ===== 5. META DE AHORRO ===== --}}
<div class="fe-panel" id="panel-goal">
    <div class="fe-panel-header">
        <div class="fe-panel-icon" style="background:rgba(245,158,11,0.2);">🎯</div>
        <div>
            <div class="fe-panel-title">Planificador de Metas de Ahorro</div>
            <div class="fe-panel-sub">¿Cuánto debes ahorrar por mes para alcanzar tu objetivo?</div>
        </div>
    </div>
    <div class="fe-grid-2">
        <div>
            <div class="fe-input-group">
                <label class="fe-label" for="goal-name">¿Para qué estás ahorrando?</label>
                <input class="fe-input" id="goal-name" type="text" placeholder="Viaje a Europa, Auto, Emergencia..." oninput="calcGoal()">
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="goal-target">Monto objetivo</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="goal-target" type="number" min="0" placeholder="50000" oninput="calcGoal()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="goal-saved">Ya tengo ahorrado</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="goal-saved" type="number" min="0" placeholder="5000" oninput="calcGoal()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="goal-months">Plazo (meses)</label>
                <input class="fe-input" id="goal-months" type="number" min="1" placeholder="24" oninput="calcGoal()">
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="goal-rate">Rendimiento mensual del ahorro (%) <span style="color:var(--text-muted)">opcional</span></label>
                <div class="fe-input-prefix"><span class="fe-prefix">%</span>
                    <input class="fe-input" id="goal-rate" type="number" min="0" step="0.01" placeholder="0.5" oninput="calcGoal()">
                </div>
            </div>
        </div>
        <div id="goal-result" class="fe-result-area">
            <div class="fe-result-empty">Define tu meta para ver el plan de ahorro</div>
        </div>
    </div>
</div>

{{-- ===== 6. INFLACIÓN ===== --}}
<div class="fe-panel" id="panel-inflation">
    <div class="fe-panel-header">
        <div class="fe-panel-icon" style="background:rgba(192,132,252,0.2);">📉</div>
        <div>
            <div class="fe-panel-title">Calculadora de Inflación</div>
            <div class="fe-panel-sub">Cuánto pierde el poder adquisitivo de tu dinero con el tiempo</div>
        </div>
    </div>
    <div class="fe-grid-2">
        <div>
            <div class="fe-input-group">
                <label class="fe-label" for="inf-amount">Cantidad de dinero hoy</label>
                <div class="fe-input-prefix"><span class="fe-prefix">$</span>
                    <input class="fe-input" id="inf-amount" type="number" min="0" placeholder="100000" oninput="calcInflation()">
                </div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="inf-rate">Tasa de inflación anual (%)</label>
                <div class="fe-input-prefix"><span class="fe-prefix">%</span>
                    <input class="fe-input" id="inf-rate" type="number" min="0" step="0.1" placeholder="4.5" oninput="calcInflation()">
                </div>
                <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">MX ~4.5% | US ~3.3% | EU ~2.6% (referencia 2024)</div>
            </div>
            <div class="fe-input-group">
                <label class="fe-label" for="inf-years">En cuántos años</label>
                <input class="fe-input" id="inf-years" type="number" min="1" max="50" placeholder="10" oninput="calcInflation()">
            </div>
        </div>
        <div id="inflation-result" class="fe-result-area">
            <div class="fe-result-empty">Ingresa los datos para calcular el impacto de la inflación</div>
        </div>
    </div>
</div>

{{-- ===== 7. CONVERSOR DE DIVISAS ===== --}}
<div class="fe-panel" id="panel-currency">
    <div class="fe-panel-header">
        <div class="fe-panel-icon" style="background:rgba(96,165,250,0.2);">🔄</div>
        <div>
            <div class="fe-panel-title">Conversor de Divisas</div>
            <div class="fe-panel-sub">Tasas de cambio en tiempo real — API pública gratuita (open.er-api.com)</div>
        </div>
    </div>
    <div style="max-width:600px;">
        <div id="currency-status" class="fe-info-box" style="margin-bottom:16px;">
            <span id="currency-status-text">⏳ Cargando tasas de cambio...</span>
        </div>
        <div class="fe-grid-3" style="align-items:flex-end;gap:12px;">
            <div class="fe-input-group" style="margin-bottom:0;">
                <label class="fe-label" for="curr-amount">Cantidad</label>
                <div class="fe-input-prefix"><span class="fe-prefix">💵</span>
                    <input class="fe-input" id="curr-amount" type="number" min="0" placeholder="1000" oninput="convertCurrency()">
                </div>
            </div>
            <div class="fe-input-group" style="margin-bottom:0;">
                <label class="fe-label" for="curr-from">De</label>
                <select class="fe-input fe-select" id="curr-from" onchange="convertCurrency()"></select>
            </div>
            <div class="fe-input-group" style="margin-bottom:0;">
                <label class="fe-label" for="curr-to">A</label>
                <select class="fe-input fe-select" id="curr-to" onchange="convertCurrency()"></select>
            </div>
        </div>
        <div id="currency-result" class="fe-result-area" style="margin-top:16px;">
            <div class="fe-result-empty">Esperando tasas de cambio...</div>
        </div>
        <div id="currency-rates-grid" style="display:none;margin-top:16px;">
            <div style="font-size:12px;font-weight:700;color:var(--text-muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:1px;">Tasas populares vs USD</div>
            <div id="rates-grid" class="fe-grid-rates"></div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* FIN-EASY Styles */
.fe-tab-bar {
    display: flex; gap: 6px; flex-wrap: wrap;
    margin-bottom: 20px; padding: 6px;
    background: var(--bg-surface);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-lg);
}
.fe-tab {
    flex: 1; min-width: 120px;
    padding: 10px 14px;
    background: none; border: none;
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    font-size: 13px; font-weight: 500;
    font-family: var(--font-family);
    cursor: pointer;
    transition: all var(--transition-fast);
    white-space: nowrap;
}
.fe-tab:hover { background: var(--bg-card); color: var(--text-primary); }
.fe-tab.active { background: var(--gradient-brand); color: white; font-weight: 700; box-shadow: 0 4px 12px rgba(124,58,237,0.4); }

.fe-panel { display: none; }
.fe-panel.active { display: block; animation: fadeInUp 0.3s ease; }

.fe-panel-header { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
.fe-panel-icon { width: 48px; height: 48px; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
.fe-panel-title { font-size: 18px; font-weight: 800; color: var(--text-primary); }
.fe-panel-sub { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }

.fe-grid-2 { display: grid; grid-template-columns: 1fr 1.2fr; gap: 24px; }
.fe-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }

.fe-input-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
.fe-label { font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; }
.fe-input-prefix { position: relative; display: flex; align-items: center; }
.fe-prefix { position: absolute; left: 12px; color: var(--text-muted); font-size: 13px; font-weight: 600; pointer-events: none; }
.fe-input-prefix .fe-input { padding-left: 32px !important; }
.fe-input {
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    padding: 11px 14px;
    font-size: 14px;
    font-family: var(--font-family);
    width: 100%;
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}
.fe-input:focus { outline: none; border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(124,58,237,0.15); }
.fe-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }

.fe-result-area {
    background: var(--bg-surface);
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-lg);
    padding: 20px;
    display: flex; flex-direction: column; gap: 14px;
    align-self: start;
}
.fe-result-empty { color: var(--text-muted); font-size: 13px; text-align: center; padding: 24px 0; }

.fe-result-kpi { display: flex; flex-direction: column; }
.fe-result-kpi .kpi-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); }
.fe-result-kpi .kpi-value { font-size: 26px; font-weight: 900; color: var(--text-primary); line-height: 1.1; }
.fe-result-kpi .kpi-sub { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }

.fe-divider { height: 1px; background: var(--border-subtle); margin: 4px 0; }

.fe-progress-bar { height: 8px; border-radius: var(--radius-full); background: var(--bg-elevated); overflow: hidden; margin-top: 8px; }
.fe-progress-fill { height: 100%; border-radius: var(--radius-full); transition: width 0.5s ease; }

.fe-budget-row { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--border-subtle); }
.fe-budget-row:last-child { border-bottom: none; }
.fe-budget-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

.fe-info-box { background: rgba(96,165,250,0.08); border: 1px solid rgba(96,165,250,0.2); border-radius: var(--radius-md); padding: 14px 16px; font-size: 13px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 14px; }

.fe-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.fe-table th { padding: 8px 12px; background: var(--bg-elevated); color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; }
.fe-table th:first-child { text-align: center; }
.fe-table td { padding: 8px 12px; border-bottom: 1px solid var(--border-subtle); text-align: right; color: var(--text-secondary); }
.fe-table td:first-child { text-align: center; color: var(--text-muted); }
.fe-table tr:hover td { background: var(--bg-card); }

.fe-highlight { color: var(--color-success); font-weight: 700; }
.fe-danger { color: var(--color-danger); font-weight: 700; }
.fe-warning { color: var(--color-warning); font-weight: 700; }

.fe-grid-rates { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
.fe-rate-card { background: var(--bg-elevated); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 10px 12px; }
.fe-rate-card .rate-pair { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
.fe-rate-card .rate-value { font-size: 16px; font-weight: 800; color: var(--text-primary); margin-top: 2px; }

.fe-comparison { display: flex; gap: 12px; margin-top: 8px; }
.fe-comp-card { flex: 1; background: var(--bg-elevated); border-radius: var(--radius-md); padding: 12px; border: 1px solid var(--border-subtle); }
.fe-comp-card.better { border-color: rgba(16,185,129,0.4); background: rgba(16,185,129,0.06); }
.fe-comp-card.worse { border-color: rgba(239,68,68,0.3); background: rgba(239,68,68,0.05); }
.fe-comp-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); }
.fe-comp-value { font-size: 18px; font-weight: 900; margin-top: 2px; }
.fe-comp-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

@media (max-width: 768px) {
    .fe-grid-2 { grid-template-columns: 1fr; }
    .fe-grid-3 { grid-template-columns: 1fr 1fr; }
    .fe-grid-rates { grid-template-columns: repeat(2, 1fr); }
    .fe-tab { font-size: 11px; padding: 8px 10px; }
}
</style>
@endpush

@push('scripts')
<script>
// ─── HELPERS ────────────────────────────────────────────────────────────────
const fmt = (n, cur = 'MXN') => new Intl.NumberFormat('es-MX', {
    style: 'currency', currency: cur, maximumFractionDigits: 2
}).format(n);

const fmtN = n => new Intl.NumberFormat('es-MX', { maximumFractionDigits: 2 }).format(n);

function kpi(label, value, sub = '', cls = '') {
    return `<div class="fe-result-kpi">
        <div class="kpi-label">${label}</div>
        <div class="kpi-value ${cls}">${value}</div>
        ${sub ? `<div class="kpi-sub">${sub}</div>` : ''}
    </div>`;
}

function divider() { return '<div class="fe-divider"></div>'; }

// ─── TABS ────────────────────────────────────────────────────────────────────
document.querySelectorAll('.fe-tab').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.fe-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.fe-panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('panel-' + btn.dataset.tab).classList.add('active');
    });
});

// ─── 1. PRESUPUESTO 50/30/20 ─────────────────────────────────────────────────
function calcBudget() {
    const income  = parseFloat(document.getElementById('budget-income').value) || 0;
    const cur     = document.getElementById('budget-currency').value;
    const el      = document.getElementById('budget-result');
    if (!income) { el.innerHTML = '<div class="fe-result-empty">Ingresa tu ingreso mensual</div>'; return; }

    const needs   = income * 0.50;
    const wants   = income * 0.30;
    const savings = income * 0.20;

    const items = [
        { label: '🏠 Necesidades', pct: 50, val: needs,   color: '#7C3AED', sub: 'Renta, servicios, alimentación, transporte' },
        { label: '🎉 Deseos',      pct: 30, val: wants,   color: '#60A5FA', sub: 'Entretenimiento, salidas, suscripciones'    },
        { label: '💰 Ahorro',      pct: 20, val: savings, color: '#10B981', sub: 'Fondo de emergencia, inversión, deudas'     },
    ];

    el.innerHTML = kpi('Ingreso mensual neto', fmt(income, cur)) + divider() +
        items.map(i => `
            <div class="fe-budget-row">
                <div class="fe-budget-dot" style="background:${i.color};box-shadow:0 0 6px ${i.color};"></div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:700;color:var(--text-primary);">${i.label} <span style="color:var(--text-muted);">(${i.pct}%)</span></div>
                    <div style="font-size:11px;color:var(--text-muted);">${i.sub}</div>
                    <div class="fe-progress-bar">
                        <div class="fe-progress-fill" style="width:${i.pct}%;background:${i.color};"></div>
                    </div>
                </div>
                <div style="font-size:16px;font-weight:800;color:var(--text-primary);white-space:nowrap;">${fmt(i.val, cur)}</div>
            </div>
        `).join('') +
        divider() +
        `<div style="font-size:11px;color:var(--text-muted);text-align:center;">
            Ahorro anual proyectado: <strong style="color:var(--color-success);">${fmt(savings * 12, cur)}</strong>
        </div>`;
}

// ─── 2. INTERÉS COMPUESTO ────────────────────────────────────────────────────
let ciChart = null;
function calcCompound() {
    const P    = parseFloat(document.getElementById('ci-initial').value)  || 0;
    const pm   = parseFloat(document.getElementById('ci-monthly').value)  || 0;
    const r    = parseFloat(document.getElementById('ci-rate').value)     || 0;
    const yrs  = parseInt(document.getElementById('ci-years').value)      || 0;
    const n    = parseInt(document.getElementById('ci-freq').value)       || 12;
    const el   = document.getElementById('compound-result');

    if (!r || !yrs) { el.innerHTML = '<div class="fe-result-empty">Completa los campos para ver la proyección</div>'; return; }

    const rn = r / 100 / n;
    const months = yrs * 12;
    const totalPeriods = yrs * n;

    // Future value of lump sum
    const fvLump = P * Math.pow(1 + rn, totalPeriods);
    // Future value of monthly contributions (annuity)
    const fvContrib = pm > 0 ? pm * ((Math.pow(1 + r/100/12, months) - 1) / (r/100/12)) : 0;
    const total = fvLump + fvContrib;
    const invested = P + (pm * months);
    const gains = total - invested;

    el.innerHTML =
        kpi('Capital final proyectado', fmt(total), `En ${yrs} año${yrs>1?'s':''}`, 'fe-highlight') +
        divider() +
        kpi('Total invertido', fmt(invested)) +
        kpi('Ganancias por interés', fmt(gains), `+${fmtN((gains/invested)*100)}% de retorno`) +
        divider() +
        `<div style="font-size:11px;color:var(--text-muted);">
            Por cada $100 que inviertes hoy, obtendrás <strong style="color:var(--color-success);">$${fmtN(100 * Math.pow(1 + r/100, yrs))}</strong> en ${yrs} años
        </div>`;

    // Chart
    const canvas = document.getElementById('compound-chart');
    canvas.style.display = 'block';
    const labels = [], dataTotal = [], dataInvested = [];
    for (let y = 0; y <= yrs; y++) {
        labels.push(`Año ${y}`);
        const tp = y * n;
        const lump = P * Math.pow(1 + rn, tp);
        const contrib = pm > 0 ? pm * ((Math.pow(1 + r/100/12, y*12) - 1) / (r/100/12)) : 0;
        dataTotal.push(Math.round(lump + contrib));
        dataInvested.push(Math.round(P + pm * y * 12));
    }
    if (ciChart) ciChart.destroy();
    ciChart = new Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [
                { label: 'Capital total', data: dataTotal,   borderColor: '#10B981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4, pointRadius: 3 },
                { label: 'Solo lo invertido', data: dataInvested, borderColor: '#60A5FA', backgroundColor: 'rgba(96,165,250,0.05)', fill: true, tension: 0.4, borderDash: [5,5], pointRadius: 3 },
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#94A3B8', font: { size: 11 } } } },
            scales: {
                x: { ticks: { color: '#64748B', font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.04)' } },
                y: { ticks: { color: '#64748B', font: { size: 10 }, callback: v => '$' + (v/1000).toFixed(0) + 'k' }, grid: { color: 'rgba(255,255,255,0.04)' } }
            }
        }
    });
}

// ─── 3. CRÉDITO / HIPOTECA ───────────────────────────────────────────────────
function calcLoan() {
    const principal = parseFloat(document.getElementById('loan-amount').value) || 0;
    const down      = parseFloat(document.getElementById('loan-down').value)   || 0;
    const rate      = parseFloat(document.getElementById('loan-rate').value)   || 0;
    const period    = document.getElementById('loan-period').value;
    const duration  = parseInt(document.getElementById('loan-years').value)    || 0;
    const el        = document.getElementById('loan-result');

    if (!principal || !rate || !duration) { el.innerHTML = '<div class="fe-result-empty">Completa los datos del préstamo</div>'; return; }

    const loanAmt = principal - down;
    const months  = period === 'years' ? duration * 12 : duration;
    const rMonthly = rate / 100 / 12;

    const payment = loanAmt * rMonthly / (1 - Math.pow(1 + rMonthly, -months));
    const totalPaid     = payment * months;
    const totalInterest = totalPaid - loanAmt;

    el.innerHTML =
        kpi('Cuota mensual', fmt(payment), 'Pago fijo cada mes', 'fe-highlight') +
        divider() +
        kpi('Total a pagar', fmt(totalPaid)) +
        kpi('Intereses totales', fmt(totalInterest), `${fmtN((totalInterest/loanAmt)*100)}% del monto original`, 'fe-danger') +
        kpi('Monto financiado', fmt(loanAmt)) +
        divider() +
        `<div style="font-size:11px;color:var(--text-muted);">
            Por cada $1,000 prestados pagas <strong style="color:var(--color-warning);">$${fmtN(1000 * totalInterest/loanAmt)}</strong> en intereses
        </div>`;

    // Amortization table (first 12 months)
    const tableEl = document.getElementById('loan-table');
    const amortEl = document.getElementById('loan-amort');
    let bal = loanAmt;
    let rows = `<thead><tr>
        <th>#</th><th>Cuota</th><th>Capital</th><th>Interés</th><th>Saldo</th>
    </tr></thead><tbody>`;
    for (let i = 1; i <= Math.min(12, months); i++) {
        const intPart = bal * rMonthly;
        const capPart = payment - intPart;
        bal -= capPart;
        rows += `<tr><td>${i}</td><td>${fmt(payment)}</td><td style="color:var(--color-success);">${fmt(capPart)}</td><td style="color:var(--color-danger);">${fmt(intPart)}</td><td>${fmt(Math.max(0,bal))}</td></tr>`;
    }
    rows += '</tbody>';
    tableEl.innerHTML = rows;
    amortEl.style.display = 'block';
}

// ─── 4. LIQUIDAR DEUDA ───────────────────────────────────────────────────────
function calcDebt() {
    const balance = parseFloat(document.getElementById('debt-balance').value) || 0;
    const rate    = parseFloat(document.getElementById('debt-rate').value)    || 0;
    const minPay  = parseFloat(document.getElementById('debt-min').value)     || 0;
    const extra   = parseFloat(document.getElementById('debt-extra').value)   || 0;
    const el      = document.getElementById('debt-result');

    if (!balance || !rate || !minPay) { el.innerHTML = '<div class="fe-result-empty">Ingresa los datos de tu deuda</div>'; return; }

    const rMonth = rate / 100;

    function simulate(payment) {
        let bal = balance, months = 0, totalInt = 0;
        while (bal > 0 && months < 1200) {
            const intCharge = bal * rMonth;
            totalInt += intCharge;
            bal = bal + intCharge - payment;
            months++;
        }
        return { months, totalInt: Math.max(0, totalInt) };
    }

    const minInterest = balance * rMonth;
    if (minPay <= minInterest) {
        el.innerHTML = `<div style="color:var(--color-danger);font-size:13px;font-weight:600;">⚠️ Tu pago mínimo ($${fmtN(minPay)}) no cubre ni los intereses ($${fmtN(minInterest.toFixed(2))}). La deuda crecerá indefinidamente.</div>`;
        return;
    }

    const res1 = simulate(minPay);
    const res2 = extra > 0 ? simulate(minPay + extra) : null;

    el.innerHTML =
        kpi('Meses para liquidar (mínimo)', `${res1.months} meses`, `${(res1.months/12).toFixed(1)} años`) +
        kpi('Intereses totales (mínimo)', fmt(res1.totalInt), '', 'fe-danger') +
        kpi('Costo total real', fmt(balance + res1.totalInt)) +
        divider();

    if (res2) {
        const saved = res1.totalInt - res2.totalInt;
        const monthsSaved = res1.months - res2.months;
        el.innerHTML +=
            `<div class="fe-comparison">
                <div class="fe-comp-card worse">
                    <div class="fe-comp-label">Pago mínimo</div>
                    <div class="fe-comp-value fe-danger">${res1.months} meses</div>
                    <div class="fe-comp-sub">${fmt(res1.totalInt)} en intereses</div>
                </div>
                <div class="fe-comp-card better">
                    <div class="fe-comp-label">Con +${fmt(extra)} extra</div>
                    <div class="fe-comp-value fe-highlight">${res2.months} meses</div>
                    <div class="fe-comp-sub">${fmt(res2.totalInt)} en intereses</div>
                </div>
            </div>
            <div style="font-size:12px;color:var(--color-success);font-weight:700;margin-top:10px;text-align:center;">
                Pagas extra ${fmt(extra)}/mes → ahorras ${fmt(saved)} y terminas ${monthsSaved} meses antes 🎉
            </div>`;
    }
}

// ─── 5. META DE AHORRO ───────────────────────────────────────────────────────
function calcGoal() {
    const target  = parseFloat(document.getElementById('goal-target').value)  || 0;
    const saved   = parseFloat(document.getElementById('goal-saved').value)   || 0;
    const months  = parseInt(document.getElementById('goal-months').value)    || 0;
    const rate    = parseFloat(document.getElementById('goal-rate').value)    || 0;
    const name    = document.getElementById('goal-name').value || 'tu meta';
    const el      = document.getElementById('goal-result');

    if (!target || !months) { el.innerHTML = '<div class="fe-result-empty">Define tu meta para ver el plan</div>'; return; }

    const needed = target - saved;
    if (needed <= 0) { el.innerHTML = '<div style="color:var(--color-success);font-weight:700;text-align:center;padding:20px;">🎉 ¡Ya alcanzaste la meta!</div>'; return; }

    let monthlySaving;
    if (rate > 0) {
        const r = rate / 100;
        monthlySaving = needed * r / (Math.pow(1 + r, months) - 1);
    } else {
        monthlySaving = needed / months;
    }

    const progress = Math.min(100, (saved / target) * 100);

    el.innerHTML =
        kpi(`Ahorro mensual para "${name}"`, fmt(monthlySaving), `Para alcanzar ${fmt(target)} en ${months} meses`, 'fe-highlight') +
        divider() +
        kpi('Restante por ahorrar', fmt(needed)) +
        kpi('Ya tienes', fmt(saved)) +
        `<div>
            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">Progreso actual</div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div class="fe-progress-bar" style="flex:1;height:12px;">
                    <div class="fe-progress-fill" style="width:${progress}%;background:var(--gradient-brand);"></div>
                </div>
                <span style="font-size:13px;font-weight:700;color:var(--text-primary);">${fmtN(progress)}%</span>
            </div>
        </div>` +
        divider() +
        `<div style="font-size:11px;color:var(--text-muted);">
            Al ritmo de ${fmt(monthlySaving)}/mes llegas el
            <strong style="color:var(--color-primary-light);">${getTargetDate(months)}</strong>
        </div>`;
}

function getTargetDate(months) {
    const d = new Date();
    d.setMonth(d.getMonth() + months);
    return d.toLocaleDateString('es-MX', { month: 'long', year: 'numeric' });
}

// ─── 6. INFLACIÓN ────────────────────────────────────────────────────────────
function calcInflation() {
    const amount = parseFloat(document.getElementById('inf-amount').value) || 0;
    const rate   = parseFloat(document.getElementById('inf-rate').value)   || 0;
    const years  = parseInt(document.getElementById('inf-years').value)    || 0;
    const el     = document.getElementById('inflation-result');

    if (!amount || !rate || !years) { el.innerHTML = '<div class="fe-result-empty">Ingresa los datos para calcular</div>'; return; }

    const futureValue = amount / Math.pow(1 + rate/100, years);
    const lostValue   = amount - futureValue;
    const lostPct     = (lostValue / amount) * 100;

    // What would need to invest to maintain purchasing power
    const needed = amount * Math.pow(1 + rate/100, years);

    el.innerHTML =
        kpi('Poder adquisitivo en ' + years + ' años', fmt(futureValue), `Tu dinero de hoy valdrá esto en ${years} años`, 'fe-warning') +
        divider() +
        kpi('Pierdes', fmt(lostValue), `-${fmtN(lostPct)}% de poder de compra`, 'fe-danger') +
        kpi('Para mantener poder adquisitivo necesitas', fmt(needed), `Con ${rate}% de rendimiento anual`) +
        divider() +
        `<div style="font-size:11px;color:var(--text-muted);">
            Para que tu dinero no pierda valor debes invertirlo a una tasa <strong style="color:var(--color-primary-light);">mayor al ${rate}% anual</strong>
        </div>`;
}

// ─── 7. CONVERSOR DE DIVISAS ─────────────────────────────────────────────────
let exchangeRates = null;
const POPULAR_PAIRS = ['MXN','USD','EUR','GBP','CAD','JPY','COP','ARS','BRL','CHF','AUD','CLP'];

async function loadExchangeRates() {
    const statusEl = document.getElementById('currency-status-text');
    try {
        const res  = await fetch('https://open.er-api.com/v6/latest/USD');
        const data = await res.json();
        if (data.result !== 'success') throw new Error('API error');
        exchangeRates = data.rates;
        const updated = new Date(data.time_last_update_utc).toLocaleString('es-MX');
        statusEl.textContent = `✅ Tasas actualizadas: ${updated}`;
        document.getElementById('currency-status').style.background = 'rgba(16,185,129,0.08)';
        document.getElementById('currency-status').style.borderColor = 'rgba(16,185,129,0.25)';
        populateCurrencySelects();
        renderRatesGrid();
        convertCurrency();
    } catch(e) {
        statusEl.textContent = '⚠️ No se pudo conectar a la API. Verifica tu conexión a internet.';
        document.getElementById('currency-status').style.borderColor = 'rgba(239,68,68,0.3)';
    }
}

function populateCurrencySelects() {
    const fromSel = document.getElementById('curr-from');
    const toSel   = document.getElementById('curr-to');
    const currencies = Object.keys(exchangeRates).sort();
    const makeOption = (c, sel) => `<option value="${c}" ${c===sel?'selected':''}>${c}</option>`;
    fromSel.innerHTML = currencies.map(c => makeOption(c, 'MXN')).join('');
    toSel.innerHTML   = currencies.map(c => makeOption(c, 'USD')).join('');
}

function renderRatesGrid() {
    const grid = document.getElementById('rates-grid');
    const usd = exchangeRates['USD'];
    grid.innerHTML = POPULAR_PAIRS.filter(c => c !== 'USD').map(c => {
        const rate = exchangeRates[c];
        return `<div class="fe-rate-card">
            <div class="rate-pair">USD → ${c}</div>
            <div class="rate-value">${fmtN(rate)}</div>
        </div>`;
    }).join('');
    document.getElementById('currency-rates-grid').style.display = 'block';
}

function convertCurrency() {
    if (!exchangeRates) return;
    const amount = parseFloat(document.getElementById('curr-amount').value) || 0;
    const from   = document.getElementById('curr-from').value;
    const to     = document.getElementById('curr-to').value;
    const el     = document.getElementById('currency-result');

    if (!amount) { el.innerHTML = '<div class="fe-result-empty">Ingresa una cantidad para convertir</div>'; return; }

    // Convert through USD base
    const inUSD    = amount / exchangeRates[from];
    const result   = inUSD * exchangeRates[to];
    const rate     = exchangeRates[to] / exchangeRates[from];
    const rateBack = exchangeRates[from] / exchangeRates[to];

    el.innerHTML =
        kpi(`${fmtN(amount)} ${from} equivale a`, `${fmtN(result)} ${to}`, '', 'fe-highlight') +
        divider() +
        `<div style="display:flex;flex-direction:column;gap:6px;font-size:13px;color:var(--text-secondary);">
            <div>1 ${from} = <strong style="color:var(--text-primary);">${fmtN(rate)} ${to}</strong></div>
            <div>1 ${to} = <strong style="color:var(--text-primary);">${fmtN(rateBack)} ${from}</strong></div>
        </div>`;
}

// Init
loadExchangeRates();
</script>
@endpush

@endsection

