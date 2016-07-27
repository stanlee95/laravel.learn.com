<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('card_id')->unique();
            $table->dateTime('valid_to')->nullable();
            $table->string('password')->nullable();;
            $table->string('role')->default('student');
            $table->string('avatar')->nullable();
            $table->enum('status', array('allow', 'deny'));
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id')
                ->references('user_id')
                ->on('place_access')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
