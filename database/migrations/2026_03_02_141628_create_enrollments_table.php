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
    Schema::create('enrollments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('track_id')->constrained()->onDelete('cascade');
        $table->enum('plan', ['monthly', 'quarterly', 'yearly']); // yearly = one-time
        $table->decimal('amount_paid', 15, 2);
        $table->string('currency', 3);
        $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
        $table->timestamp('start_date')->nullable();
        $table->timestamp('end_date')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
