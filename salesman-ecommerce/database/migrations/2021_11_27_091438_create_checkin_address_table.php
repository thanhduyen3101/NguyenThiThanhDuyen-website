<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckinAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_address', function (Blueprint $table) {
            $table->string('checkin_id')->unique();
            $table->string('salesman_id');
            $table->string('image');
            $table->double('lat');
            $table->double('long');
            $table->timestamps();

            $table->foreign('salesman_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_address');
    }
}
