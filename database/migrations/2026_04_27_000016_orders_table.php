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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('invoice_no')->unique()->index();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('status')->default('Pending')->index(); // Pending, Processed, Delivered, Cancelled
            $table->string('pay_method')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('delivery_time')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('coupon_id')->nullable();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('currency')->default('BDT');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
