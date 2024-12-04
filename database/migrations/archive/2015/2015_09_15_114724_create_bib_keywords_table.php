<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibKeywordsTable
 */
class CreateBibKeywordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_keywords', function (Blueprint $table) {
            $table->increments('keyword_id');
            $table->string('keyword', 120);
            $table->char('index_id', 1)->index('index_id');
            $table->unique(['keyword','index_id'], 'keyword_index_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_keywords');
    }
}
