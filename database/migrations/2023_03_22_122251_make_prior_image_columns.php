<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('manuskriptseiten_bilder', function (Blueprint $t) {
            $t->after('Bildlink', function (Blueprint $t) {
                $t->string('new_image_link', 500)->nullable();
                $t->string('prior_image_link', 500)->nullable();
            });
        });

        Schema::table('ms_manuscript_pages_images', function (Blueprint $t) {
            $t->after('image_link', function (Blueprint $t) {
                $t->string('new_image_link', 500)->nullable();
                $t->string('prior_image_link', 500)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
