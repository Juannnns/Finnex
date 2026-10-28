<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class FinBotController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = app('view')->getShared()['authUser'] ?? User::with('account.transactions')->find(session('finnex_user_id'));
        $account = $user ? $user->account : null;

        $balance = $account ? (float) $account->balance : 0;
        $expenses = $account ? (float) $account->transactions()->whereIn('type', ['expense', 'transfer_out'])->sum('amount') : 0;
        $name = $user ? explode(' ', $user->name)[0] : 'Usuario';

        $initialMessages = [
            [
                'role' => 'bot',
                'text' => "¡Hola, {$name}! Soy **FIN-BOT**, tu asistente financiero inteligente 🤖\n\nTu saldo disponible actual es **$" . number_format($balance, 0, ',', '.') . "** y tus gastos registrados suman **$" . number_format($expenses, 0, ',', '.') . "**.\n\nPuedes pedirme:\n- *\"Añadir gasto de 45000 en supermercado\"*\n- *\"¿Cuál es mi saldo?\"*\n- *\"¿Cuánto he gastado?\"*\n- *\"Dame un plan de ahorro\"*",
                'time' => now()->format('H:i'),
            ],
        ];

        return view('finbot.index', compact('initialMessages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        /** @var User|null $user */
        $user = app('view')->getShared()['authUser'] ?? User::with('account.transactions')->find(session('finnex_user_id'));
        $account = $user ? $user->account : null;

        $userMessage = $request->input('message');
        $response    = $this->getBotResponse($userMessage, $user, $account);

        return response()->json([
            'success'  => true,
            'response' => $response,
            'time'     => now()->format('H:i'),
        ]);
    }

    protected function getBotResponse(string $input, ?User $user, ?Account $account): string
    {
        $inputLower = mb_strtolower($input);

        if (!$account) {
            return "No encontré una cuenta activa vinculada a tu usuario. Por favor verifica tu sesión.";
        }

        // Registrar gasto real en base de datos
        // Ej: "añadir gasto de 50000 en comida", "gasté 25000 en transporte", "pago de 30000 luz"
        if (preg_match('/(?:añadir|agregar|gaste|gasté|agrega|pagué|pague|compra).*?(\d[\d\.]*)\s*(?:en|de|por)?\s*(.*)/iu', $input, $matches)) {
            $rawAmount = str_replace('.', '', $matches[1]);
            $amount = (float) $rawAmount;
            $rawCategory = trim($matches[2] ?? '');

            // Limpieza de categoría
            $category = 'Otros';
            $icon = '🛒';
            $cleanCat = mb_strtolower($rawCategory);

            if (str_contains($cleanCat, 'comida') || str_contains($cleanCat, 'super') || str_contains($cleanCat, 'alimento') || str_contains($cleanCat, 'restaurante')) {
                $category = 'Alimentación';
                $icon = '🛒';
            } elseif (str_contains($cleanCat, 'transporte') || str_contains($cleanCat, 'gasolina') || str_contains($cleanCat, 'uber') || str_contains($cleanCat, 'taxi')) {
                $category = 'Transporte';
                $icon = '🚗';
            } elseif (str_contains($cleanCat, 'arriendo') || str_contains($cleanCat, 'vivienda') || str_contains($cleanCat, 'casa')) {
                $category = 'Vivienda';
                $icon = '🏠';
            } elseif (str_contains($cleanCat, 'luz') || str_contains($cleanCat, 'agua') || str_contains($cleanCat, 'gas') || str_contains($cleanCat, 'internet') || str_contains($cleanCat, 'servicio')) {
                $category = 'Servicios';
                $icon = '⚡';
            } elseif (str_contains($cleanCat, 'salud') || str_contains($cleanCat, 'farmacia') || str_contains($cleanCat, 'medico')) {
                $category = 'Salud';
                $icon = '💊';
            } elseif (str_contains($cleanCat, 'cine') || str_contains($cleanCat, 'netflix') || str_contains($cleanCat, 'spotify') || str_contains($cleanCat, 'juego')) {
                $category = 'Entretenimiento';
                $icon = '🎭';
            }

            if ($amount > 0) {
                if ($account->balance < $amount) {
                    return "⚠️ No pude registrar el gasto: Tu saldo actual ($" . number_format($account->balance, 0, ',', '.') . ") es inferior al monto que intentas registrar ($" . number_format($amount, 0, ',', '.') . ").";
                }

                // Descontar saldo y crear transacción
                $account->decrement('balance', $amount);
                $account->refresh();

                Transaction::create([
                    'account_id'    => $account->id,
                    'type'          => 'expense',
                    'amount'        => $amount,
                    'description'   => !empty($rawCategory) ? "Gasto: " . ucfirst($rawCategory) : "Gasto registrado por FIN-BOT",
                    'category'      => $category,
                    'icon'          => $icon,
                    'color'         => 'orange',
                    'transacted_at' => now(),
                ]);

                return "✅ **Gasto registrado exitosamente en la base de datos.**\n\n• **Monto:** $" . number_format($amount, 0, ',', '.') . "\n• **Categoría:** {$category}\n• **Nuevo saldo disponible:** $" . number_format($account->balance, 0, ',', '.') . "\n\nYa puedes ver este movimiento en tu Dashboard y FIN-360.";
            }
        }

        // Consultar saldo actual
        if (str_contains($inputLower, 'saldo') || str_contains($inputLower, 'cuanto tengo') || str_contains($inputLower, 'cuánto tengo') || str_contains($inputLower, 'dinero disponible')) {
            return "💰 Tu saldo disponible actual en tu cuenta Finnex (**{$account->account_number}**) es de **$" . number_format($account->balance, 0, ',', '.') . " COP**.";
        }

        // Consultar gastos
        if (str_contains($inputLower, 'cuanto he gastado') || str_contains($inputLower, 'cuánto he gastado') || str_contains($inputLower, 'mis gastos') || str_contains($inputLower, 'total gastado')) {
            $totalExpenses = (float) $account->transactions()->whereIn('type', ['expense', 'transfer_out'])->sum('amount');
            return "📉 Según tus registros en la base de datos, has gastado un total de **$" . number_format($totalExpenses, 0, ',', '.') . " COP**.";
        }

        // Consultar ingresos
        if (str_contains($inputLower, 'ingreso') || str_contains($inputLower, 'sueldo') || str_contains($inputLower, 'salario')) {
            $totalIncome = (float) $account->transactions()->whereIn('type', ['income', 'transfer_in'])->sum('amount');
            return "📈 Tus ingresos acumulados registrados en tu cuenta suman **$" . number_format($totalIncome, 0, ',', '.') . " COP**.";
        }

        // Transferencias
        if (str_contains($inputLower, 'transfer') || str_contains($inputLower, 'enviar dinero')) {
            return "💸 Para realizar transferencias entre cuentas Finnex en tiempo real, dirígete a la sección **[Transferencias]({{ route('transfers') }})** en el menú lateral. Solo necesitas el correo de la otra persona y el monto.";
        }

        // Reglas de asesoría financiera
        $rules = [
            ['keywords' => ['ahorro', 'ahorrar', 'guardar'], 'responses' => [
                "💡 **Estrategia de ahorro FINNEX:**\nCon tu saldo actual de $" . number_format($account->balance, 0, ',', '.') . ", te recomendamos mantener la regla 50/30/20:\n- 50% en necesidades básicas\n- 30% en gastos personales\n- 20% para tu fondo de emergencia.",
            ]],
            ['keywords' => ['meta', 'objetivo', 'vacacion'], 'responses' => [
                "🎯 Tus metas activas están sincronizadas con tu cuenta. Puedes revisarlas en la sección **FIN-360**.",
            ]],
            ['keywords' => ['seguridad', 'fraude', 'sospechoso', 'tarjeta'], 'responses' => [
                "🛡️ Todas tus operaciones bancarias están protegidas por el módulo de seguridad **FinSafe**.",
            ]],
            ['keywords' => ['hola', 'buenos', 'buenas', 'saludos'], 'responses' => [
                "¡Hola! ¿En qué puedo ayudarte hoy? Puedes preguntarme por tu **saldo**, tus **gastos** o pedirme que **registre un nuevo gasto** 🤖",
            ]],
            ['keywords' => ['gracias', 'perfecto', 'excelente', 'genial'], 'responses' => [
                "¡Con gusto! Estoy aquí siempre para ayudarte a cuidar tus finanzas 😊",
            ]],
        ];

        foreach ($rules as $rule) {
            foreach ($rule['keywords'] as $kw) {
                if (str_contains($inputLower, $kw)) {
                    $responses = $rule['responses'];
                    return $responses[array_rand($responses)];
                }
            }
        }

        return "🤖 Puedes pedirme cosas como:\n- *\"¿Cuál es mi saldo?\"*\n- *\"¿Cuánto he gastado?\"*\n- *\"Añadir gasto de 30000 en almuerzo\"*\n- *\"¿Cómo hago una transferencia?\"*";
    }
}

