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
        Schema::table('currency_orders', function (Blueprint $table) {
            $table->decimal('currency_amount', 15, 2); // Amount for the selected currency
            // Amount for the exchange currency
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('currency_orders', function (Blueprint $table) {
            $table->dropColumn('currency_amount');
            
        });
    }
};
