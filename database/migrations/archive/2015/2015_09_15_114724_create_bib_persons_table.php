<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibPersonsTable
 */
class CreateBibPersonsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_persons', function (Blueprint $table) {
            $table->increments('person_id');
            $table->string('last_name', 60)->index('Lastname');
            $table->string('first_name', 60);
            $table->text('annotations');
            $table->unique(['last_name','first_name'], 'name');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_persons');
    }
}
