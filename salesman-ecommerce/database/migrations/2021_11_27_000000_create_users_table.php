<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('tel')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('sex')->nullable();
            $table->tinyInteger('admin')->default(0);
            $table->tinyInteger('enabled')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->string('type_id');
            $table->foreign('type_id')->references('type_id')->on('type')->onDelete('cascade');
            $table->string('courses_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
