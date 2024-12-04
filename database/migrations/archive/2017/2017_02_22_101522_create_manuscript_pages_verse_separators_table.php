<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuscriptPagesVerseSeparatorsTable
 */
class CreateManuscriptPagesVerseSeparatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_verse_separators', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("manuskriptseiten_id");
            $table->integer("sure");
            $table->integer("vers");
            $table->integer("wort");
            $table->string("type");

            // If manuscript has its own counting, map to different koranstelle
            $table->integer("self_sure")->nullable();
            $table->integer("self_vers")->nullable();
            $table->integer("self_wort")->nullable();

            $table->text("comment")->nullable();

            $table->text("description");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manuskriptseiten_verse_separators');
    }
}
