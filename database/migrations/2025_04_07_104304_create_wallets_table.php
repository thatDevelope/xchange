<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->uuid('wallet_id')->unique()->default(DB::raw('uuid()')); // Unique UUID for the wallet
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['main', 'savings']); // Type of wallet
            $table->decimal('balance', 15, 2)->default(0); // Wallet balance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
