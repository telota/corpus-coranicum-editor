<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibTitlesKeywordsTable
 */
class CreateBibTitlesKeywordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_titles_keywords', function (Blueprint $table) {
            $table->increments('title_keyword_id');
            $table->integer('title_id')->unsigned();
            $table->integer('keyword_id')->unsigned()->index('keyword_id');
            $table->unique(['title_id','keyword_id'], 'title_id_keyword_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_titles_keywords');
    }
}
