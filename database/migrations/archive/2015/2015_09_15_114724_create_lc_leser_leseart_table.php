<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcLeserLeseartTable
 */
class CreateLcLeserLeseartTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_leser_leseart', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('leser')->default(0);
            $table->integer('leseart')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_leser_leseart');
    }
}