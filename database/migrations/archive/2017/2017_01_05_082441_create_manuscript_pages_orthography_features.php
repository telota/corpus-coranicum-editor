<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuscriptPagesOrthographyFeatures
 */
class CreateManuscriptPagesOrthographyFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_variant_orthography_features', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("orthography_variant_id");
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
        Schema::dropIfExists('manuskriptseiten_variant_orthography_features');
    }
}
