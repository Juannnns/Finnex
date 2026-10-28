<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_number',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('transacted_at', 'desc');
    }

    /**
     * Genera un número de cuenta único con formato FNX-XXXXXXXXXX
     */
    public static function generateAccountNumber(): string
    {
        do {
            $number = 'FNX-' . strtoupper(substr(md5(uniqid()), 0, 10));
        } while (static::where('account_number', $number)->exists());

        return $number;
    }
}
