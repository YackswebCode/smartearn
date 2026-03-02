<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lectures', function (Blueprint $table) {
            if (!Schema::hasColumn('lectures', 'is_preview')) {
                $table->boolean('is_preview')->default(false)->after('order');
            }
        });
    }

    public function down()
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropColumn('is_preview');
        });
    }
};