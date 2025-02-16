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
        Schema::create('offer_tables', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('currency_from', 10); // Example: NGN
            $table->string('currency_to', 10); // Example: USD
            $table->decimal('amount', 15, 2); // Amount being traded
            $table->decimal('exchange_rate', 10, 4); // Exchange rate (e.g., 1 USD = 770 NGN)
            $table->string('payment_method', 50); // Example: Bank Transfer
            $table->enum('status', ['open', 'closed', 'canceled'])->default('open'); // Offer status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_tables');
    }
};
