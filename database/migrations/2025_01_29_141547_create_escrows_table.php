<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('escrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id')->constrained('create_trades_tables')->onDelete('cascade'); // Links to create_trades_tables table
            $table->decimal('amount', 15, 2); // Amount held in escrow
            $table->string('currency', 10); // Currency type (e.g., USD)
            $table->enum('status', ['held', 'released', 'disputed'])->default('held'); // Escrow status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escrows');
    }
};
