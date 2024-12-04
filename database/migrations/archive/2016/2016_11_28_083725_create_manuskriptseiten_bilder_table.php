<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuskriptseitenBilderTable
 */
class CreateManuskriptseitenBilderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_bilder', function (Blueprint $table) {

            // Incrementing ID
            $table->increments('id');

            // ID der zugehörigen Manuskriptseite
            $table->integer("manuskriptseite");

            // Link zum Bild im Digilib-Laufwerk
            $table->text("Bildlink");

            // Link zum Original aus einer anderen Quelle, insofern vorhanden
            $table->text("Bildlink_extern");

            // Nachweis/Bildzitat
            $table->text("Bildlinknachweis");

            // Bildtauglichkeit: ja, nein, ohneBild
            $table->text("webtauglich", 20);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manuskriptseiten_bilder');
    }
}
