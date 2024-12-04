<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuscriptBasicReadingsFeaturesTable
 */
class CreateManuscriptBasicReadingsFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskript_basic_readings_features', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("manuskript_id");
            $table->string("feature");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manuskript_basic_readings_features');
    }
}
