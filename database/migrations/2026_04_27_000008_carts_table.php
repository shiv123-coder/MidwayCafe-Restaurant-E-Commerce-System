<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name', 255);
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->string('product_order')->default('no')->index();
            $table->string('shipping_address')->default('N/A');
            $table->string('invoice_no')->nullable()->index();
            $table->string('pay_method')->nullable();
            $table->string('delivery_time')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('coupon_id')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
