<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcLeseartTable
 */
class CreateLcLeseartTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_leseart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sure')->default(0);
            $table->integer('vers')->default(0);
            $table->text('kommentar')->nullable();
            $table->text('kommentar_intern')->nullable();
            $table->enum('kanonisch', array('0','1'))->default('0');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_leseart');
    }
}
