<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id')->unique();
            $table->string('title');
            $table->string('owner_id');
            $table->string('category');
            $table->string('size');
            $table->float('price');
            $table->text('description');
            $table->string('image');
            $table->timestamps();

            $table->foreign('owner_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('category')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
