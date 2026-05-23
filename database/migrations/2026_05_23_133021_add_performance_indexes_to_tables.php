<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexesToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->index(['user_id', 'product_order']);
        });

        Schema::table('rates', function (Blueprint $table) {
            $table->index(['product_id', 'user_id']);
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'product_order']);
        });

        Schema::table('rates', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'user_id']);
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
        });
    }
}
