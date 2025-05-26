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
        Schema::create('virtual_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Add this line
            $table->string('wallet_reference')->unique();
            $table->string('wallet_name');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('bvn')->nullable();
            $table->date('bvn_dob')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

       

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_wallets');
    }
};
