<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibIndicesTable
 */
class CreateBibIndicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_indices', function (Blueprint $table) {
            $table->char('index_id', 1)->primary();
            $table->string('index_name', 30);
            $table->string('element_name', 15);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_indices');
    }
}
