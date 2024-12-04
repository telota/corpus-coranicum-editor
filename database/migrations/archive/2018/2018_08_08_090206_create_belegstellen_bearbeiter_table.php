<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBelegstellenBearbeiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belegstellen_bearbeiter', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("belegstelle");
            $table->foreign("belegstelle")->references("ID")->on("belegstellen");
            $table->string("bearbeiter");
            $table->string("zusatz");
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('belegstellen_bearbeiter');
    }
}
