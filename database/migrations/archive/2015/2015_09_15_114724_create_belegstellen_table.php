<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBelegstellenTable
 */
class CreateBelegstellenTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belegstellen', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('Titel', 1000);
            $table->string('Sprache', 1000);
            $table->string("Sprache_richtung", 3)->nullable();
            $table->string('Ort', 1000);
            $table->text('Datierung');
            $table->text('Edition');
            $table->text('Uebersetzung');
            $table->text('Identifikator');
            $table->text('Textsorte');
            $table->text('HinweiseaufEdition');
            $table->text('SchlagwortPersonen');
            $table->text('SchlagwortOrte');
            $table->text('SchlagwortSonst');
            $table->text('Stichwort');
            $table->text('TextstelleKoran');
            $table->text('Anmerkungen');
            $table->text('Anmerkungen_en');
            $table->text('Uebersetzer');
            $table->text('Bearbeiter');
            $table->text('Einstelldatum');
            $table->text('Anderungsdatum');
            $table->text('Originalsprache');
            $table->text('Transkription');
            $table->text('Uebersetzung_dt');
            $table->text('Uebersetzung_en');
            $table->text('Uebersetzung_fr');
            $table->text('Uebersetzung_ar');
            $table->text('Autor');
            $table->text('allfields');
            $table->string('webtauglich', 20);
            $table->text('Bibeltext');
            $table->text('Vermittlungssprache');
            $table->text('Literatur');
            $table->string('kategorie');
            $table->timestamps();
            $table->text('lastAuthor');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('belegstellen');
    }
}
