<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcLeseartQuelleTable
 */
class CreateLcLeseartQuelleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_leseart_quelle', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('leseart')->default(0);
            $table->integer('quelle')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_leseart_quelle');
    }
}
