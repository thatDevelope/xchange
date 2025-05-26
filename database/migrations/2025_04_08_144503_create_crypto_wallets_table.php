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
        Schema::create('crypto_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link wallet to user
            $table->string('wallet_address')->unique(); // Address of the wallet
            $table->string('wallet_name')->nullable(); // Name (e.g., MetaMask)
            $table->string('network')->nullable(); // Blockchain network (e.g., Ethereum)
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_wallets');
    }
};
