<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateManuskriptTable
 */
class CreateManuskriptTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskript', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->text('Kodextitel');
            $table->text('Format');
            $table->text('Umfang');
            $table->text('Aufbewahrungsort');
            $table->integer('AufbewahrungsortId')->unsigned();
            $table->text('Signatur');
            $table->text('Herkunftsort');
            $table->text('Datierung');
            $table->text('TextstelleKoran');
            $table->text('Materialzustand');
            $table->text('Zeilenzahl');
            $table->text('Fundort');
            $table->text('Textspiegel');
            $table->text('Materialart');
            $table->text('Kodikologie');
            $table->text('Schriftduktus');
            $table->text('Palaographie');
            $table->text('Textgliederung');
            $table->text('Literatur');
            $table->text('Bearbeiter');
            $table->text('Text');
            $table->text('Bild');
            $table->text('Kommentar_intern');
            $table->text('Kommentar');
            $table->text('webtauglich');
            $table->text('Ornamente');
            $table->text('Bildnachweis');
            $table->text("remarks_additional_folio")->nullable();
            $table->text("remarks_foliation")->nullable();
            $table->text("remarks_pagination")->nullable();
            $table->mediumText("transliteration_alt")->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manuskript');
    }
}
