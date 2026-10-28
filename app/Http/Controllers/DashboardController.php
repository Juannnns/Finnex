<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user    = app('view')->getShared()['authUser'];
        $account = $user->account;

        if (!$account) {
            // Sin cuenta aún → datos en cero
            return view('dashboard.index', $this->emptyData());
        }

        // Transacciones del mes actual (con fallback a todas las transacciones)
        $thisMonth = $account->transactions()
            ->whereMonth('transacted_at', now()->month)
            ->whereYear('transacted_at', now()->year)
            ->get();

        if ($thisMonth->isEmpty()) {
            $thisMonth = $account->transactions()->get();
        }

        $income   = (float) $thisMonth->whereIn('type', ['income', 'transfer_in'])->sum('amount');
        $expenses = (float) $thisMonth->whereIn('type', ['expense', 'transfer_out'])->sum('amount');
        $savings  = $income - $expenses;

        // Últimas 6 transacciones para el dashboard
        $transactions = $account->transactions()->limit(6)->get()->map(fn($tx) => [
            'icon'     => $tx->icon,
            'desc'     => $tx->description,
            'category' => $tx->category,
            'date'     => $tx->transacted_at->diffForHumans(),
            'amount'   => $tx->isCredit() ? $tx->amount : -$tx->amount,
            'type'     => $tx->isCredit() ? 'income' : 'expense',
            'color'    => $tx->color,
        ])->toArray();

        // Score de salud financiero simple basado en ratio ahorro/ingreso
        $healthScore = $income > 0 ? min(100, max(25, (int)(($savings / $income) * 50 + 50))) : 50;

        $balance = (float) $account->balance;
        $goals = [
            ['name' => 'Fondo de Emergencia', 'icon' => '🚨', 'current' => min(5000000, max(100000, round($balance * 0.40))), 'target' => 5000000],
            ['name' => 'Vacaciones 2026',     'icon' => '🏖️', 'current' => min(2500000, max(50000, round($balance * 0.20))), 'target' => 2500000],
            ['name' => 'Inversión',           'icon' => '📈', 'current' => min(4000000, max(50000, round($balance * 0.30))), 'target' => 4000000],
        ];

        $data = [
            'balance'         => $balance,
            'income'          => $income,
            'expenses'        => $expenses,
            'savings'         => $savings,
            'health_score'    => $healthScore,
            'income_delta'    => '+' . number_format(($income / max(1, $expenses) - 1) * 100, 1) . '%',
            'expenses_delta'  => number_format($expenses / max(1, $income) * 100, 1) . '%',
            'savings_delta'   => $savings >= 0 ? '+' . number_format($savings / max(1, $income) * 100, 1) . '%' : '-0%',
            'transactions'    => $transactions,
            'alerts'          => $this->getAlerts($account),
            'goals'           => $goals,
        ];

        return view('dashboard.index', $data);
    }

    private function getAlerts($account): array
    {
        $alerts = [];

        // Alerta si saldo bajo
        if ($account->balance < 500000) {
            $alerts[] = [
                'level' => 'high',
                'icon'  => '⚠️',
                'title' => 'Saldo bajo en tu cuenta',
                'desc'  => 'Tu saldo está por debajo de $500.000.',
                'time'  => 'Ahora',
            ];
        }

        // Alerta transferencias recientes
        $recentTransfer = $account->transactions()
            ->whereIn('type', ['transfer_in', 'transfer_out'])
            ->where('transacted_at', '>=', now()->subHours(24))
            ->first();

        if ($recentTransfer) {
            $alerts[] = [
                'level' => 'info',
                'icon'  => '💸',
                'title' => 'Transferencia reciente',
                'desc'  => $recentTransfer->description . ' por $' . number_format($recentTransfer->amount, 0, ',', '.'),
                'time'  => $recentTransfer->transacted_at->diffForHumans(),
            ];
        }

        if (empty($alerts)) {
            $alerts[] = [
                'level' => 'info',
                'icon'  => '🎯',
                'title' => 'Todo al día',
                'desc'  => 'No tienes alertas pendientes.',
                'time'  => 'Ahora',
            ];
        }

        return $alerts;
    }

    private function emptyData(): array
    {
        return [
            'balance'        => 0,
            'income'         => 0,
            'expenses'       => 0,
            'savings'        => 0,
            'health_score'   => 0,
            'income_delta'   => '0%',
            'expenses_delta' => '0%',
            'savings_delta'  => '0%',
            'transactions'   => [],
            'alerts'         => [],
            'goals'          => [],
        ];
    }
}
