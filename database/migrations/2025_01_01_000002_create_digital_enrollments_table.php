<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('digital_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('track_id')->constrained('digital_tracks')->cascadeOnDelete();
            $table->string('plan')->default('monthly');              // monthly, quarterly, one_time
            $table->decimal('amount_paid', 10, 2);
            $table->string('currency', 10)->default('NGN');
            $table->string('status')->default('active');            // active, completed, cancelled
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('digital_enrollments');
    }
};