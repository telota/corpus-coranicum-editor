<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateVeranstaltungenMigration
 */
class CreateVeranstaltungenMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veranstaltungen', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("titel");
            $table->dateTime("datum_start");
            $table->dateTime("datum_ende");
            $table->string("ort");
            $table->text("beschreibung");
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('veranstaltungen');
    }
}
