<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('buyer_email')->nullable()->after('user_id');
        $table->string('buyer_name')->nullable()->after('buyer_email');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['buyer_email', 'buyer_name']);
    });
}
};
