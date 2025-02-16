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
        Schema::create('create_trades_tables', function (Blueprint $table) {
            $table->id();
            // $table->id(); // Auto-increment primary key (Trade ID)
            $table->foreignId('offer_id')->constrained('offer_tables')->onDelete('cascade'); // Links to offers table
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade'); // Buyer’s user ID
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade'); // Seller’s user ID
            $table->decimal('amount', 15, 2); // Amount traded
            $table->decimal('exchange_rate', 10, 4); // Agreed exchange rate
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending'); // Payment status
            $table->enum('escrow_status', ['held', 'released', 'disputed'])->default('held'); // Escrow status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_trades_tables');
    }
};
