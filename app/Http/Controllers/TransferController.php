<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user    = app('view')->getShared()['authUser'];
        $account = $user->account;

        // Últimas transferencias de esta cuenta
        $transfers = $account
            ? $account->transactions()
                ->whereIn('type', ['transfer_in', 'transfer_out'])
                ->limit(10)
                ->get()
            : collect();

        return view('transfers.index', compact('user', 'account', 'transfers'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email',
            'amount'          => 'required|numeric|min:1000',
            'description'     => 'nullable|string|max:200',
        ], [
            'recipient_email.required' => 'El correo del destinatario es requerido.',
            'recipient_email.email'    => 'Ingresa un correo válido.',
            'amount.required'          => 'El monto es requerido.',
            'amount.min'               => 'El monto mínimo de transferencia es $1.000.',
        ]);

        /** @var User $sender */
        $sender        = app('view')->getShared()['authUser'];
        $senderAccount = $sender->account;

        // No puede transferirse a sí mismo
        if ($request->recipient_email === $sender->email) {
            return back()->withErrors(['recipient_email' => 'No puedes transferirte dinero a ti mismo.']);
        }

        // Buscar destinatario
        $recipient = User::where('email', $request->recipient_email)->first();
        if (!$recipient || !$recipient->account) {
            return back()->withErrors(['recipient_email' => 'No se encontró ninguna cuenta asociada a ese correo.']);
        }

        $recipientAccount = $recipient->account;
        $amount           = (float) $request->amount;
        $description      = $request->description ?: "Transferencia a {$recipient->name}";

        // Validar saldo suficiente
        if ($senderAccount->balance < $amount) {
            return back()->withErrors(['amount' => 'Saldo insuficiente para realizar la transferencia.']);
        }

        // Ejecutar transferencia atómica
        DB::transaction(function () use ($senderAccount, $recipientAccount, $amount, $description, $sender, $recipient) {
            // Debitar cuenta origen
            $senderAccount->decrement('balance', $amount);

            // Acreditar cuenta destino
            $recipientAccount->increment('balance', $amount);

            // Registrar en cuenta origen (salida)
            Transaction::create([
                'account_id'         => $senderAccount->id,
                'related_account_id' => $recipientAccount->id,
                'type'               => 'transfer_out',
                'amount'             => $amount,
                'description'        => "Transferencia a {$recipient->name}",
                'category'           => 'Transferencia',
                'icon'               => '💸',
                'color'              => 'blue',
                'transacted_at'      => now(),
            ]);

            // Registrar en cuenta destino (entrada)
            Transaction::create([
                'account_id'         => $recipientAccount->id,
                'related_account_id' => $senderAccount->id,
                'type'               => 'transfer_in',
                'amount'             => $amount,
                'description'        => "Transferencia de {$sender->name}",
                'category'           => 'Transferencia',
                'icon'               => '💸',
                'color'              => 'green',
                'transacted_at'      => now(),
            ]);
        });

        return back()->with('success', "¡Transferencia de $" . number_format($amount, 0, ',', '.') . " a {$recipient->name} realizada exitosamente!");
    }
}
