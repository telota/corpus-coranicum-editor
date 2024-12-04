<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBelegstellenUpdateTable
 */
class CreateBelegstellenUpdateTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Belegstellen_update', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('Bearbeiter', 1000);
            $table->text('Einstelldatum');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Belegstellen_update');
    }
}
