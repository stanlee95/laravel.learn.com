<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposedProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposed_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('software_requirements')->nullable();
            $table->string('recomended_literature')->nullable();
            $table->timestamps();

             $table->foreign('id')
                ->references('project_id')
                ->on('projects')
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
        Schema::drop('proposed_projects');
    }
}
