<?php
// database/migrations/xxxx_xx_xx_create_lectures_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('lectures')) {
            Schema::create('lectures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('track_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('video_url')->nullable(); // YouTube/Vimeo URL or uploaded file path
                $table->integer('order')->default(0);
                $table->boolean('is_preview')->default(false); // whether free preview
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('lectures');
    }
};