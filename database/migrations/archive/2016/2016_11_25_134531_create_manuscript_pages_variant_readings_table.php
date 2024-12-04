<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuscriptPagesVariantReadingsTable
 */
class CreateManuscriptPagesVariantReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_variant_readings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("manuskriptseite_id"); // Keep German column names for convention in other CC-projects
            $table->integer("sure");
            $table->integer("vers");
            $table->integer("wort");
            $table->string("feature");
            $table->text("comment");
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
        Schema::dropIfExists('manuskriptseiten_variant_readings');
    }
}
