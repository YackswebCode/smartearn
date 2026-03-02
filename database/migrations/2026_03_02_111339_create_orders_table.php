<?php 

// database/migrations/xxxx_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // buyer (customer)
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('vendor_id');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3);
            $table->decimal('affiliate_commission', 15, 2);
            $table->decimal('vendor_earnings', 15, 2);
            $table->string('reference')->unique();
            $table->string('payment_gateway')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('affiliate_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};