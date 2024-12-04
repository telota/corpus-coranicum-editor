<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBelegstellenBilderTable
 */
class CreateBelegstellenBilderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belegstellen_bilder', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("belegstelle");
            $table->string("bildlink");
            $table->text("bildnachweis");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('belegstellen_bilder');
    }
}
