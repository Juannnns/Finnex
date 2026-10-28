<?php

namespace App\Http\Controllers;

use App\Models\User;

class Fin360Controller extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = app('view')->getShared()['authUser'] ?? User::with('account.transactions')->find(session('finnex_user_id'));

        if (!$user || !$user->account) {
            return view('fin360.index', $this->emptyData());
        }

        $account = $user->account;
        $transactions = $account->transactions;

        $income = (float) $transactions->whereIn('type', ['income', 'transfer_in'])->sum('amount');
        $expenses = (float) $transactions->whereIn('type', ['expense', 'transfer_out'])->sum('amount');
        $savings = $income - $expenses;

        // Obligaciones (vivienda, servicios, arriendo)
        $obligations = (float) $transactions->whereIn('category', ['Vivienda', 'Servicios'])->sum('amount');
        if ($obligations == 0 && $expenses > 0) {
            $obligations = round($expenses * 0.35);
        }

        // Score de salud financiera
        $healthScore = $income > 0 ? min(100, max(25, (int)(($savings / $income) * 50 + 50))) : 50;

        // Categorías de gastos dinámicas desde BD
        $categoryColors = [
            'Vivienda'        => '#7C3AED',
            'Alimentación'    => '#60A5FA',
            'Transporte'      => '#10B981',
            'Salud'           => '#F59E0B',
            'Entretenimiento' => '#C084FC',
            'Servicios'       => '#EAB308',
            'Transferencia'   => '#3B82F6',
            'Otros'           => '#94A3B8',
        ];

        $expenseTxs = $transactions->whereIn('type', ['expense', 'transfer_out']);
        $totalExp = $expenseTxs->sum('amount');

        $expense_categories = [];
        if ($totalExp > 0) {
            foreach ($expenseTxs->groupBy('category') as $catName => $items) {
                $amt = (float) $items->sum('amount');
                $pct = round(($amt / $totalExp) * 100);
                $name = $catName ?: 'Otros';
                $expense_categories[] = [
                    'name'    => $name,
                    'amount'  => $amt,
                    'percent' => $pct,
                    'color'   => $categoryColors[$name] ?? '#94A3B8',
                ];
            }
            usort($expense_categories, fn($a, $b) => $b['amount'] <=> $a['amount']);
        } else {
            $expense_categories = [
                ['name' => 'Sin gastos aún', 'amount' => 0, 'percent' => 100, 'color' => '#94A3B8'],
            ];
        }

        // Metas financieras dinámicas según el saldo de la cuenta
        $balance = (float) $account->balance;
        $goals = [
            [
                'name'     => 'Fondo de Emergencia',
                'icon'     => '🚨',
                'current'  => min(5000000, max(100000, round($balance * 0.40))),
                'target'   => 5000000,
                'deadline' => 'Jun 2026',
                'monthly'  => 250000,
            ],
            [
                'name'     => 'Vacaciones 2026',
                'icon'     => '🏖️',
                'current'  => min(2500000, max(50000, round($balance * 0.20))),
                'target'   => 2500000,
                'deadline' => 'Dic 2026',
                'monthly'  => 150000,
            ],
            [
                'name'     => 'Inversiones y Portafolio',
                'icon'     => '📈',
                'current'  => min(4000000, max(50000, round($balance * 0.30))),
                'target'   => 4000000,
                'deadline' => 'Mar 2027',
                'monthly'  => 200000,
            ],
        ];

        // Recomendaciones inteligentes basadas en datos reales
        $recommendations = [];
        if ($savings > 0) {
            $recAmt = number_format(round($savings * 0.2), 0, ',', '.');
            $recommendations[] = [
                'icon'   => '💡',
                'title'  => 'Capacidad de ahorro activa',
                'desc'   => "Tienes un excedente neto positivo de \${$recAmt}. Te recomendamos destinarlo a tu Fondo de Emergencia.",
                'impact' => 'Alto impacto',
                'level'  => 'success',
            ];
        } else {
            $recommendations[] = [
                'icon'   => '⚠️',
                'title'  => 'Gastos cercanos o superiores a ingresos',
                'desc'   => 'Tus gastos mensuales están superando tus ingresos. Considera optimizar categorías no esenciales.',
                'impact' => 'Urgente',
                'level'  => 'warning',
            ];
        }

        $recommendations[] = [
            'icon'   => '🔐',
            'title'  => 'Seguridad de cuenta activa',
            'desc'   => 'Tus transacciones y transferencias están monitoreadas por el sistema FinSafe de Finnex.',
            'impact' => 'Protegido',
            'level'  => 'info',
        ];

        $recommendations[] = [
            'icon'   => '🎯',
            'title'  => 'Metas en progreso',
            'desc'   => "Con tu saldo actual de \${number_format($balance, 0, ',', '.')}, estás cubriendo el progreso de tus metas clave.",
            'impact' => 'Positivo',
            'level'  => 'purple',
        ];

        $data = [
            'health_score'       => $healthScore,
            'income'             => $income,
            'expenses'           => $expenses,
            'savings'            => $savings,
            'obligations'        => $obligations,
            'expense_categories' => $expense_categories,
            'goals'              => $goals,
            'recommendations'    => $recommendations,
        ];

        return view('fin360.index', $data);
    }

    private function emptyData(): array
    {
        return [
            'health_score'       => 50,
            'income'             => 0,
            'expenses'           => 0,
            'savings'            => 0,
            'obligations'        => 0,
            'expense_categories' => [],
            'goals'              => [],
            'recommendations'    => [],
        ];
    }
}
