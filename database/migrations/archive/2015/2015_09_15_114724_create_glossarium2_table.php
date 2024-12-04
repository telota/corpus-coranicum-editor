<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateGlossarium2Table
 */
class CreateGlossarium2Table extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glossarium2', function (Blueprint $table) {
            $table->integer('Gloss2ID', true);
            $table->integer('Gloss1ID');
            $table->text('typ');
            $table->text('belegstelle');
            $table->text('bearbeiter');
            $table->text('ort');
            $table->text('datierung');
            $table->text('uebersetzung_nachweis');
            $table->text('originaltext');
            $table->text('umschrift');
            $table->text('bildlink');
            $table->text('dateiname');
            $table->text('edition');
            $table->text('uebersetzung');
            $table->text('anmerkung');
            $table->text('sprache');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('glossarium2');
    }
}
