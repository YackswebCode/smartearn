<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('digital_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('digital_faculties')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('instructors')->nullable();
            $table->string('image')->nullable(); // path to uploaded image
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->integer('reviews_count')->default(0);
            $table->integer('duration_months')->default(3);

            // Pricing – flexible plans in course's base currency
            $table->decimal('price', 10, 2)->default(0.00);          // fallback/base monthly
            $table->decimal('monthly_price', 10, 2)->nullable();
            $table->decimal('quarterly_price', 10, 2)->nullable();
            $table->decimal('one_time_price', 10, 2)->nullable();

            $table->string('currency', 10)->default('NGN');          // NGN, USD, etc.
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('digital_tracks');
    }
};