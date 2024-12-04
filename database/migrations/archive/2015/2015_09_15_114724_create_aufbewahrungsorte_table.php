<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateAufbewahrungsorteTable
 */
class CreateAufbewahrungsorteTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aufbewahrungsorte', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('ort', 1000);
            $table->string('country_code', 2);
            $table->string('name', 1000);
            $table->text('beschreibung')->nullable();
            $table->string('link', 1000)->nullable();
            $table->string('bild_link', 1000)->nullable();
            $table->string('bild_orig', 1000)->nullable();
            $table->text('bild_beschreibung')->nullable();
            $table->float('longitude', 30, 5)->nullable();
            $table->float('latitude', 30, 5)->nullable();
            $table->string('geonames', 1000)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('aufbewahrungsorte');
    }
}
