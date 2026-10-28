<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            // Para transferencias: cuenta destino (null si no es transferencia)
            $table->foreignId('related_account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->enum('type', ['income', 'expense', 'transfer_in', 'transfer_out']);
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->string('category')->default('Otros');
            $table->string('icon')->default('💳');
            $table->string('color')->default('blue');
            $table->timestamp('transacted_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

