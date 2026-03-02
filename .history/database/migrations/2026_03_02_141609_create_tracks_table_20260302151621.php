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
    Schema::create('tracks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->text('description');
        $table->text('detailed_explanation')->nullable(); // for popup
        $table->decimal('price_monthly', 15, 2)->nullable();
        $table->decimal('price_quarterly', 15, 2)->nullable();
        $table->decimal('price_yearly', 15, 2)->nullable(); // one-time
        $table->string('currency', 3)->default('NGN');
        $table->string('image')->nullable();
        $table->integer('duration_months')->nullable(); // for diploma
        $table->boolean('is_diploma')->default(false);
        $table->integer('order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
