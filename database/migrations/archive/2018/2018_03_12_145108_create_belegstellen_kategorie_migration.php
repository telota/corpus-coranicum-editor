<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBelegstellenKategorieMigration
 */
class CreateBelegstellenKategorieMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belegstellen_kategorie', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            //Todo: später rausnehmen: "classification"
            $table->string('classification');
            $table->integer("supercategory");
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
        Schema::drop('belegstellen_kategorie');
    }
}
