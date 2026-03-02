<?php
// database/migrations/xxxx_create_lectures_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url')->nullable(); // Could be YouTube/Vimeo link or local path
            $table->integer('order')->default(0);
            $table->boolean('is_preview')->default(false); // Optional: allow free preview
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lectures');
    }
};