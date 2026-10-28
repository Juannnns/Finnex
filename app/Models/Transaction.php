<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'related_account_id',
        'type',
        'amount',
        'description',
        'category',
        'icon',
        'color',
        'transacted_at',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'transacted_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function relatedAccount()
    {
        return $this->belongsTo(Account::class, 'related_account_id');
    }

    /**
     * Determina si la transacción suma (ingreso/recepción) o resta (gasto/envío)
     */
    public function isCredit(): bool
    {
        return in_array($this->type, ['income', 'transfer_in']);
    }

    /**
     * Retorna el tipo formateado en español
     */
    public function typeLabel(): string
    {
        return match ($this->type) {
            'income'       => 'Ingreso',
            'expense'      => 'Gasto',
            'transfer_in'  => 'Transferencia recibida',
            'transfer_out' => 'Transferencia enviada',
            default        => 'Movimiento',
        };
    }
}
