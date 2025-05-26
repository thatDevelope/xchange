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
        Schema::create('currency_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // References users.id
            $table->string('currency'); // Currency user wants to buy
            $table->string('exchange_currency'); // Currency they are exchanging from
            $table->decimal('amount', 15, 2); // Amount they are buying
            $table->decimal('exchange_rate', 15, 4); // Fixed exchange rate
            $table->decimal('total_price', 15, 2); // Total amount in exchange currency
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_orders');
    }
};
