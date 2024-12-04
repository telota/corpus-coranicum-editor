<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class ManuscriptPagesVariantReadingsVariantsFeatures
 */
class ManuscriptPagesVariantReadingsVariantsFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_variant_readings_variants_features', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('variant_id')->unsigned();
            $table->foreign('variant_id', 'variants_features')
                ->references('id')->on("manuskriptseiten_variant_readings_variants")
                ->onDelete("cascade");
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
        Schema::dropIfExists('manuskriptseiten_variant_readings_variants_features');
    }
}
