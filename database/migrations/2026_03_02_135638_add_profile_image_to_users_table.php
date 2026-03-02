<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('profile_image')->nullable()->after('email');
        // Also add business_name, about_me, business_description fields if not present
        $table->string('business_name')->nullable()->after('profile_image');
        $table->text('about_me')->nullable()->after('business_name');
        $table->text('business_description')->nullable()->after('about_me');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['profile_image', 'business_name', 'about_me', 'business_description']);
    });
}
};
