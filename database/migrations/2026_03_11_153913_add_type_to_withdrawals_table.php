<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->enum('type', ['affiliate', 'vendor'])->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};