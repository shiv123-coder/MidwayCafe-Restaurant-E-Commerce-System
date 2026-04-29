<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();

            $table->decimal('price', 10, 2)->default(0);

            // spelling fix (optional but recommended)
            $table->string('category')->default('regular');

            // FIXED: changed from integer → string
            $table->string('session')->default('all');

            $table->string('available')->default('yes');

            // PostgreSQL JSON field
            $table->jsonb('metadata')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
