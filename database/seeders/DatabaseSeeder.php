<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Usuario 1 ──────────────────────────────────────────────────────
        $carlos = User::create([
            'name'     => 'Carlos Mendoza',
            'email'    => 'carlos@finnex.com',
            'password' => Hash::make('finnex2024'),
            'role'     => 'Administrador',
            'phone'    => '+57 311 234 5678',
            'bio'      => 'Admin principal de Finnex. Apasionado por las finanzas personales.',
        ]);

        $carlosAccount = Account::create([
            'user_id'        => $carlos->id,
            'account_number' => Account::generateAccountNumber(),
            'balance'        => 8500000.00,
            'currency'       => 'COP',
        ]);

        // Transacciones de Carlos
        $carlosTransactions = [
            ['type' => 'income',  'amount' => 5200000, 'description' => 'Pago de salario',        'category' => 'Ingresos',        'icon' => '💼', 'color' => 'green',  'days' => 0],
            ['type' => 'expense', 'amount' => 680000,  'description' => 'Arriendo mensual',        'category' => 'Vivienda',         'icon' => '🏠', 'color' => 'blue',   'days' => 1],
            ['type' => 'expense', 'amount' => 95000,   'description' => 'Supermercado Metro',      'category' => 'Alimentación',     'icon' => '🛒', 'color' => 'orange', 'days' => 1],
            ['type' => 'expense', 'amount' => 52000,   'description' => 'Cuenta de luz',           'category' => 'Servicios',        'icon' => '⚡', 'color' => 'yellow', 'days' => 2],
            ['type' => 'income',  'amount' => 320000,  'description' => 'Freelance - Consultoría', 'category' => 'Ingresos',         'icon' => '💰', 'color' => 'green',  'days' => 4],
            ['type' => 'expense', 'amount' => 29900,   'description' => 'Netflix + Spotify',       'category' => 'Entretenimiento', 'icon' => '🎭', 'color' => 'purple', 'days' => 5],
            ['type' => 'expense', 'amount' => 145000,  'description' => 'Farmacia Colombia',       'category' => 'Salud',            'icon' => '💊', 'color' => 'blue',   'days' => 6],
        ];

        foreach ($carlosTransactions as $tx) {
            Transaction::create([
                'account_id'   => $carlosAccount->id,
                'type'         => $tx['type'],
                'amount'       => $tx['amount'],
                'description'  => $tx['description'],
                'category'     => $tx['category'],
                'icon'         => $tx['icon'],
                'color'        => $tx['color'],
                'transacted_at'=> now()->subDays($tx['days']),
            ]);
        }

        // ─── Usuario 2 ──────────────────────────────────────────────────────
        $sofia = User::create([
            'name'     => 'Sofía Ramírez',
            'email'    => 'sofia@finnex.com',
            'password' => Hash::make('finnex2024'),
            'role'     => 'Administrador',
            'phone'    => '+57 320 876 4321',
            'bio'      => 'Co-admin de Finnex. Especialista en análisis financiero.',
        ]);

        $sofiaAccount = Account::create([
            'user_id'        => $sofia->id,
            'account_number' => Account::generateAccountNumber(),
            'balance'        => 4250000.00,
            'currency'       => 'COP',
        ]);

        // Transacciones de Sofía
        $sofiaTransactions = [
            ['type' => 'income',  'amount' => 3800000, 'description' => 'Pago de salario',     'category' => 'Ingresos',        'icon' => '💼', 'color' => 'green',  'days' => 0],
            ['type' => 'expense', 'amount' => 550000,  'description' => 'Arriendo apartamento', 'category' => 'Vivienda',         'icon' => '🏠', 'color' => 'blue',   'days' => 1],
            ['type' => 'expense', 'amount' => 78000,   'description' => 'Supermercado Éxito',   'category' => 'Alimentación',     'icon' => '🛒', 'color' => 'orange', 'days' => 2],
            ['type' => 'income',  'amount' => 180000,  'description' => 'Diseño gráfico',       'category' => 'Ingresos',         'icon' => '🎨', 'color' => 'green',  'days' => 3],
            ['type' => 'expense', 'amount' => 19900,   'description' => 'Spotify Premium',      'category' => 'Entretenimiento', 'icon' => '🎵', 'color' => 'purple', 'days' => 4],
            ['type' => 'expense', 'amount' => 210000,  'description' => 'Gimnasio mensual',     'category' => 'Salud',            'icon' => '🏋️', 'color' => 'blue',   'days' => 5],
            ['type' => 'expense', 'amount' => 45000,   'description' => 'Gas natural',          'category' => 'Servicios',        'icon' => '🔥', 'color' => 'yellow', 'days' => 6],
        ];

        foreach ($sofiaTransactions as $tx) {
            Transaction::create([
                'account_id'   => $sofiaAccount->id,
                'type'         => $tx['type'],
                'amount'       => $tx['amount'],
                'description'  => $tx['description'],
                'category'     => $tx['category'],
                'icon'         => $tx['icon'],
                'color'        => $tx['color'],
                'transacted_at'=> now()->subDays($tx['days']),
            ]);
        }
    }
}
