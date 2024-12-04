<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePermalinkDataTable
 */
class CreatePermalinkDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permalink_data', function (Blueprint $table) {
            $table->increments('id');

            // Unambiguous string, a uuid
            $table->uuid('reference');

            // e.g. manuscriptpage, manuscriptpart, codex, image
            $table->string('concept');

            // e.g. id, doc, def, iiif
            $table->char('service', 4);

            // File extension, important for content negotiation
            $table->char('extension', 4);

            // Location of the corresponding file on the server
            $table->longText('filepath');

            // Human readable URL path
            $table->longText('slug');

            // Timestamps
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
        Schema::dropIfExists('permalink_data');
    }
}
