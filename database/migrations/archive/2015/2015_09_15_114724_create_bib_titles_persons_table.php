<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibTitlesPersonsTable
 */
class CreateBibTitlesPersonsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_titles_persons', function (Blueprint $table) {
            $table->increments('title_person_id');
            $table->integer('title_id')->unsigned();
            $table->integer('person_id')->unsigned();
            $table->integer('function_id')->unsigned()->default(1);
            $table->smallInteger('position')->unsigned()->default(1);
            $table->string('first_name_spelling', 60);
            $table->string('last_name_spelling', 60);
            $table->unique(['title_id','person_id','function_id'], 'title_person_function');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_titles_persons');
    }
}
