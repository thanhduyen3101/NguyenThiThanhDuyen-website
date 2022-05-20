<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('category');
            $table->integer('sold_amount');
            $table->integer('size');
            $table->float('price');
            $table->text('description');
            $table->timestamps();

            $table->foreign('owner_id')->cascadeOnUpdate()->references('id')->on('users');
            $table->foreign('category')->cascadeOnUpdate()->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
