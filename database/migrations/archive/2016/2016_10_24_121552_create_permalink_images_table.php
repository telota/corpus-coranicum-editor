<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePermalinkImagesTable
 */
class CreatePermalinkImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permalink_images', function (Blueprint $table) {
            $table->increments('id');

            // e.g. iiif
            //$table->string('concept');

            // e.g. uuid string of image id
            $table->uuid('reference');

            // canvas, annotation, sequence, manifest
            //$table->string('service');

            // name of service option, e.g. default, basic or full
            //$table->string('name');

            // original link to IIIF image viewer
            $table->string('original_base_url');

            // original id of the manuscript page
            $table->string('original_manuscript_page');

            // original id of the manuscript page image
            $table->string('original_manuscript_image');

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
        Schema::dropIfExists('permalink_images');
    }
}
