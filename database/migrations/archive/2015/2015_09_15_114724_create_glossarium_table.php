<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateGlossariumTable
 */
class CreateGlossariumTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glossarium', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->text('wort');
            $table->string('wurzel', 10);
            $table->text('literatur');
            $table->text('anmerkungen');
            $table->text('bearbeiter');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('glossarium');
    }
}
