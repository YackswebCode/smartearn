<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_transactions_table.php
public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['funding', 'withdrawal', 'purchase', 'commission', 'subscription', 'refund']);
        $table->decimal('amount', 15, 2);
        $table->string('currency', 3)->default('NGN');
        $table->enum('balance_type', ['wallet', 'affiliate', 'vendor'])->default('wallet'); // which balance was affected
        $table->decimal('balance_before', 15, 2);
        $table->decimal('balance_after', 15, 2);
        $table->string('description')->nullable();
        $table->string('reference')->unique()->nullable();
        $table->string('payment_gateway')->nullable();
        $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
        $table->json('meta')->nullable(); // for extra data like bank details
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
