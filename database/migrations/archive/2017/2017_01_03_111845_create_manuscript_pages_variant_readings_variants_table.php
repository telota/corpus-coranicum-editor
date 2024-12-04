<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuscriptPagesVariantReadingsVariantsTable
 */
class CreateManuscriptPagesVariantReadingsVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_variant_readings_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("variant_reading_id"); // Keep German column names for convention in other CC-projects
            $table->string("variant");
            $table->string("normalized");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manuskriptseiten_variant_readings_variants');
    }
}
