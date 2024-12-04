<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateKommentarTable
 */
class CreateKommentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kommentar', function (Blueprint $table) {
            $table->integer('sure')->primary();
            $table->timestamps();
            $table->mediumText('xml');
            $table->mediumText('textstruktur');
            $table->mediumText('bibliography_anmerkung');
            $table->mediumText('bibliography_kommentar');
            $table->mediumText('bibliography_literarkritik');
            $table->mediumText('bibliography_textkritik');
            $table->mediumText('bibliography_entwicklungsgeschichte');
            $table->mediumText('bibliography_inhaltstruktur');
            $table->mediumText('bibliography_situativitaet');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kommentar');
    }
}
