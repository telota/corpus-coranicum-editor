<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcLeseartLeserTable
 */
class CreateLcLeseartLeserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_leseart_leser', function (Blueprint $table) {
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
        Schema::drop('lc_leseart_leser');
    }
}
