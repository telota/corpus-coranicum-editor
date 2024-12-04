<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateImageDetailTable
 */
class CreateImageDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_details', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            // Get relation (e.g. manuscript variant readings)
            $table->string('relation');
            $table->string("relation_id");
            $table->string('image_relation');

            // Get id of original image
            $table->string('image_id');
            $table->string("title");

            // Enter a description
            $table->text("description");

            // Get coordinates
            $table->float("x");
            $table->float("y");
            $table->float("width");
            $table->float("height");

            // Save editor
            $table->integer("lastUser");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_details');
    }
}
