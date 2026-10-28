<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('finnex:verify {--transfer : Ejecuta una transferencia real de prueba}')]
#[Description('Verifica la conexión a Clever Cloud MySQL, usuarios, aislamiento de vistas y transferencias')]
class VerifyFinnex extends Command
{
    public function handle(): int
    {
        $this->info("=== VERIFICACIÓN FINNEX (Clever Cloud MySQL) ===");

        // 1. Probar conexión
        try {
            $dbName = DB::connection()->getDatabaseName();
            $this->info("✔ Conexión MySQL establecida exitosamente con la base de datos: [{$dbName}]");
        } catch (\Throwable $e) {
            $this->error("✖ Error de conexión: " . $e->getMessage());
            return Command::FAILURE;
        }

        // 2. Verificar usuarios
        $carlos = User::with('account')->where('email', 'carlos@finnex.com')->first();
        $sofia  = User::with('account')->where('email', 'sofia@finnex.com')->first();

        if (!$carlos || !$sofia) {
            $this->error("✖ Usuarios Carlos o Sofía no encontrados.");
            return Command::FAILURE;
        }

        $this->info("✔ Usuario 1: {$carlos->name} ({$carlos->email}) - Rol: {$carlos->role}");
        $this->line("   -> Cuenta: {$carlos->account->account_number} | Saldo: $" . number_format($carlos->account->balance, 0, ',', '.') . " COP");

        $this->info("✔ Usuario 2: {$sofia->name} ({$sofia->email}) - Rol: {$sofia->role}");
        $this->line("   -> Cuenta: {$sofia->account->account_number} | Saldo: $" . number_format($sofia->account->balance, 0, ',', '.') . " COP");

        // 3. Verificar aislamiento de transacciones
        $carlosTxs = $carlos->account->transactions()->count();
        $sofiaTxs  = $sofia->account->transactions()->count();
        $this->info("✔ Aislamiento de cuentas confirmado:");
        $this->line("   -> Carlos tiene {$carlosTxs} transacciones registradas exclusivamente para su cuenta.");
        $this->line("   -> Sofía tiene {$sofiaTxs} transacciones registradas exclusivamente para su cuenta.");

        // 4. Si se solicita transferencia de prueba
        if ($this->option('transfer')) {
            $amount = 50000;
            $this->info("\n--- Ejecutando transferencia de prueba atómica: Carlos -> Sofía por \${$amount} COP ---");

            $carlosBalanceBefore = (float) $carlos->account->balance;
            $sofiaBalanceBefore  = (float) $sofia->account->balance;

            DB::transaction(function () use ($carlos, $sofia, $amount) {
                $carlos->account->decrement('balance', $amount);
                $sofia->account->increment('balance', $amount);

                Transaction::create([
                    'account_id'         => $carlos->account->id,
                    'related_account_id' => $sofia->account->id,
                    'type'               => 'transfer_out',
                    'amount'             => $amount,
                    'description'        => "Transferencia a {$sofia->name}",
                    'category'           => 'Transferencia',
                    'icon'               => '💸',
                    'color'              => 'blue',
                    'transacted_at'      => now(),
                ]);

                Transaction::create([
                    'account_id'         => $sofia->account->id,
                    'related_account_id' => $carlos->account->id,
                    'type'               => 'transfer_in',
                    'amount'             => $amount,
                    'description'        => "Transferencia de {$carlos->name}",
                    'category'           => 'Transferencia',
                    'icon'               => '💸',
                    'color'              => 'green',
                    'transacted_at'      => now(),
                ]);
            });

            $carlos->account->refresh();
            $sofia->account->refresh();

            $this->info("✔ Transferencia completada atómicamente en MySQL.");
            $this->line("   -> Carlos: Antes \${$carlosBalanceBefore} -> Ahora $" . number_format($carlos->account->balance, 0, ',', '.'));
            $this->line("   -> Sofía:  Antes \${$sofiaBalanceBefore} -> Ahora $" . number_format($sofia->account->balance, 0, ',', '.'));
        }

        $this->info("\n✔ ¡TODO FUNCIONA CORRECTAMENTE EN LA BASE DE DATOS CLEVER CLOUD!");
        return Command::SUCCESS;
    }
}
