<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name')->nullable()->after('profile_image');
            }
            if (!Schema::hasColumn('users', 'about_me')) {
                $table->text('about_me')->nullable()->after('business_name');
            }
            if (!Schema::hasColumn('users', 'business_description')) {
                $table->text('business_description')->nullable()->after('about_me');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_image')) {
                $table->dropColumn('profile_image');
            }
            if (Schema::hasColumn('users', 'business_name')) {
                $table->dropColumn('business_name');
            }
            if (Schema::hasColumn('users', 'about_me')) {
                $table->dropColumn('about_me');
            }
            if (Schema::hasColumn('users', 'business_description')) {
                $table->dropColumn('business_description');
            }
        });
    }
};