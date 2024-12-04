<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuscriptPagesBasicReadingsFeaturesTable
 */
class CreateManuscriptPagesBasicReadingsFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_basic_readings_features', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('variant_reading_id');
            $table->string('feature');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manuskriptseiten_basic_readings_features');
    }
}
