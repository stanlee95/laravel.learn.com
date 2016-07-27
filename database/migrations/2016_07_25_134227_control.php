<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Control extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control', function (Blueprint $table) {
            $table->increments('control_id');
            $table->integer('user_id')->unsigned();
            $table->timestamp('input_time')->nullable();
            $table->timestamp('output_time')->nullable();
            $table->smallinteger('blocked')->nullable();
            $table->smallinteger('is_coming')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('control');
    }
}
