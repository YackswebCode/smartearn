<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('user_bank_accounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['bank', 'momo'])->default('bank');
        $table->string('bank_name')->nullable(); // for bank
        $table->string('account_name')->nullable();
        $table->string('account_number')->nullable();
        $table->string('momo_provider')->nullable(); // e.g., MTN, Vodafone
        $table->string('momo_number')->nullable();
        $table->boolean('is_default')->default(false);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bank_accounts');
    }
};
