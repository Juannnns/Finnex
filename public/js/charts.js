/**
 * FINNEX — Charts JavaScript (Chart.js)
 * charts.js
 */

document.addEventListener('DOMContentLoaded', () => {
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js not loaded');
        return;
    }

    // Global Chart defaults
    Chart.defaults.color = '#94A3B8';
    Chart.defaults.borderColor = 'rgba(167, 139, 250, 0.1)';
    Chart.defaults.font.family = "'Inter', sans-serif";

    initDashboardChart();
    initFin360DonutChart();
    initFin360TrendChart();
});

/* ================================================
   DASHBOARD — Income vs Expense Area Chart
   ================================================ */
function initDashboardChart() {
    const ctx = document.getElementById('dashboardChart');
    if (!ctx) return;

    const labels = ['Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep'];

    const incomeData  = [2800000, 3100000, 2950000, 3200000, 3050000, 3200000];
    const expenseData = [1600000, 1850000, 1700000, 1890000, 1750000, 1890000];

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Ingresos',
                    data: incomeData,
                    borderColor: '#10B981',
                    backgroundColor: createGradient(ctx, '#10B981'),
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#0A0618',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Gastos',
                    data: expenseData,
                    borderColor: '#EF4444',
                    backgroundColor: createGradient(ctx, '#EF4444'),
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#EF4444',
                    pointBorderColor: '#0A0618',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 12,
                        boxHeight: 12,
                        borderRadius: 3,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                    },
                },
                tooltip: {
                    backgroundColor: '#1A1140',
                    borderColor: 'rgba(167,139,250,0.3)',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: (ctx) => {
                            const value = new Intl.NumberFormat('es-CL', {
                                style: 'currency',
                                currency: 'CLP',
                                minimumFractionDigits: 0,
                            }).format(ctx.parsed.y);
                            return ` ${ctx.dataset.label}: ${value}`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } },
                },
                y: {
                    grid: { color: 'rgba(167,139,250,0.07)' },
                    ticks: {
                        font: { size: 11 },
                        callback: (val) => '$' + (val / 1000000).toFixed(1) + 'M',
                    },
                },
            },
        },
    });
}

/* ================================================
   FIN-360 — Expense Distribution Donut
   ================================================ */
function initFin360DonutChart() {
    const ctx = document.getElementById('fin360DonutChart');
    if (!ctx) return;

    let labels = ['Vivienda', 'Alimentación', 'Transporte', 'Salud', 'Entretenimiento', 'Otros'];
    let data = [580000, 420000, 230000, 180000, 150000, 330000];
    let backgroundColor = ['#7C3AED', '#60A5FA', '#10B981', '#F59E0B', '#C084FC', '#94A3B8'];

    if (window.fin360Categories && Array.isArray(window.fin360Categories) && window.fin360Categories.length > 0) {
        labels = window.fin360Categories.map(c => c.name);
        data = window.fin360Categories.map(c => c.amount);
        backgroundColor = window.fin360Categories.map(c => c.color || '#7C3AED');
    }

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data,
                backgroundColor,
                borderWidth: 0,
                hoverBorderWidth: 3,
                hoverBorderColor: '#1A1140',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        boxHeight: 10,
                        borderRadius: 2,
                        padding: 16,
                        font: { size: 12 },
                    },
                },
                tooltip: {
                    backgroundColor: '#1A1140',
                    borderColor: 'rgba(167,139,250,0.3)',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: (ctx) => {
                            const value = new Intl.NumberFormat('es-CL', {
                                style: 'currency',
                                currency: 'CLP',
                                minimumFractionDigits: 0,
                            }).format(ctx.parsed);
                            return ` ${ctx.label}: ${value}`;
                        },
                    },
                },
            },
        },
    });
}

/* ================================================
   FIN-360 — Monthly Trend Line
   ================================================ */
function initFin360TrendChart() {
    const ctx = document.getElementById('fin360TrendChart');
    if (!ctx) return;

    const labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep'];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Ahorro',
                    data: [280000, 320000, 290000, 310000, 350000, 295000, 330000, 310000, 360000],
                    backgroundColor: 'rgba(124,58,237,0.7)',
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Metas',
                    data: [200000, 200000, 200000, 200000, 200000, 200000, 200000, 200000, 200000],
                    type: 'line',
                    borderColor: '#F59E0B',
                    borderWidth: 2,
                    borderDash: [6, 4],
                    pointRadius: 0,
                    fill: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: { boxWidth: 12, boxHeight: 12, padding: 16 },
                },
                tooltip: {
                    backgroundColor: '#1A1140',
                    borderColor: 'rgba(167,139,250,0.3)',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: (ctx) => {
                            const value = new Intl.NumberFormat('es-CL', {
                                style: 'currency',
                                currency: 'CLP',
                                minimumFractionDigits: 0,
                            }).format(ctx.parsed.y);
                            return ` ${ctx.dataset.label}: ${value}`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } },
                },
                y: {
                    grid: { color: 'rgba(167,139,250,0.07)' },
                    ticks: {
                        font: { size: 11 },
                        callback: (val) => '$' + (val / 1000).toFixed(0) + 'K',
                    },
                },
            },
        },
    });
}

/* ================================================
   HELPERS
   ================================================ */
function createGradient(ctx, color) {
    const canvas = ctx.canvas ? ctx.canvas : ctx;
    const gradient = canvas.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, hexToRgba(color, 0.3));
    gradient.addColorStop(1, hexToRgba(color, 0.01));
    return gradient;
}

function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}
