<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateManuscriptPagesOrthographyTable
 */
class CreateManuscriptPagesOrthographyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuskriptseiten_variant_orthography', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("manuskriptseiten_id");
            $table->integer("sure");
            $table->integer("vers");
            $table->integer("wort");
            $table->string("variant");
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
        Schema::dropIfExists('manuskriptseiten_variant_orthography');
    }
}
