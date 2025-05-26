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
        Schema::table('offer_tables', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->after('user_id');

            // Optional: Add foreign key if you want cascading deletes, etc.
            $table->foreign('order_id')->references('id')->on('currency_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_tables', function (Blueprint $table) {
            //
        });
    }
};
