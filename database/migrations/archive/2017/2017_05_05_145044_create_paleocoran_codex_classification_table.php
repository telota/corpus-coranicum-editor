<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranCodexClassificationTable
 */
class CreatePaleocoranCodexClassificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_codex_classification', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer("paleocoran_manuscript_codex_id")->unsigned();
            $table->foreign("paleocoran_manuscript_codex_id", "paleocoran_codex_classification")
                ->references("id")->on("paleocoran_manuscript_codex")
                ->onDelete("cascade");

            $table->string("supercategory");
            $table->string("subcategory");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_codex_classification');
    }
}
