<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateManuskriptseitenTable
 */
class CreateManuskriptseitenTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten', function (Blueprint $table) {
            $table->integer('SeitenID', true);
            $table->integer('ManuskriptID')->default(0);
            $table->text('Bearbeiter');
            $table->text('Transkription');
            $table->text('Folio');
            $table->text('Seite');
            $table->text('FolioundSeite');
            $table->text('TextstelleKoran');
            $table->text('Zeilenzahl');
            $table->text('Kommentar');
            $table->text('Kommentar_intern');
            $table->text('Palaeographie');
            $table->text('Bildlink');
            $table->text('Bildlink2');
            $table->string('webtauglich', 20);
            $table->text('Format');
            $table->text('Bildlinknachweis');
            $table->text('Bildlink2nachweis');
            $table->text('Scaler');
            $table->text('digilib');
            $table->text('Ordner');
            $table->text('width');
            $table->text('thumb');
            $table->text('detail');
            $table->text('pn');
            $table->text('Ordner2');
            $table->text('thumb2');
            $table->text('detail2');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manuskriptseiten');
    }
}
