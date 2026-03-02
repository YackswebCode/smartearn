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
    Schema::create('business_courses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('faculty_id')->constrained('business_faculties')->onDelete('cascade');
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description');
        $table->text('detailed_explanation')->nullable();
        $table->string('instructors'); // e.g., "Moreira Oyebambo, jamein Freemean"
        $table->decimal('rating', 3, 2)->default(0);
        $table->integer('reviews_count')->default(0);
        $table->decimal('price', 15, 2);
        $table->string('currency', 3)->default('NGN');
        $table->string('image')->nullable();
        $table->boolean('is_diploma')->default(false);
        $table->integer('duration_months')->nullable();
        $table->integer('order')->default(0);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_courses');
    }
};
