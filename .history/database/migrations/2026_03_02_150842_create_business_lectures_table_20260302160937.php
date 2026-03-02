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
    Schema::create('business_lectures', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained('business_courses')->onDelete('cascade');
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('video_url')->nullable();
        $table->integer('order')->default(0);
        $table->boolean('is_preview')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_lectures');
    }
};
