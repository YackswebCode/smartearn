<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // database/migrations/xxxx_create_withdrawals_table.php
public function up()
{
    Schema::create('withdrawals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 15, 2);
        $table->string('currency', 3)->default('NGN');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->json('account_details')->nullable(); // store bank/momo info
        $table->text('admin_note')->nullable();
        $table->timestamp('processed_at')->nullable(); // when approved/rejected
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
