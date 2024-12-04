<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibTitlesTable
 */
class CreateBibTitlesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_titles', function (Blueprint $table) {
            $table->increments('title_id');
            $table->string('title', 191)->index('title');
            $table->string('pub_in', 600);
            $table->string('pub_series', 250);
            $table->string('pub_location', 60);
            $table->string('pub_editor', 60);
            $table->string('pub_year', 15)->index('pub_year');
            $table->string('pub_edition', 15);
            $table->string('pub_isbn', 30);
            $table->string('pub_url', 250);
            $table->string('pages', 60);
            $table->string('format', 30);
            $table->text('annotations');
            $table->string('avh_location', 120);
            $table->string('avh_repository', 250);
            $table->string('avh_form', 30);
            $table->dateTime('date_created');
            $table->dateTime('date_modified');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_titles');
    }
}
