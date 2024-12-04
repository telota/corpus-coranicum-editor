<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcKkoranTable
 */
class CreateLcKkoranTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_kkoran', function (Blueprint $table) {
            $table->increments('index');
            $table->integer('sure')->unsigned()->default(0);
            $table->integer('vers')->unsigned()->default(0);
            $table->integer('wort')->unsigned()->default(0);
            $table->text('transkription');
            $table->string('wurzel', 10);
            $table->string('arab')->nullable();
            $table->unique(['sure','vers','wort'], 'sure');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_kkoran');
    }
}
