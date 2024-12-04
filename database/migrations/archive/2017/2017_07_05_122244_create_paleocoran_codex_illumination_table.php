<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranCodexIlluminationTable
 */
class CreatePaleocoranCodexIlluminationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_codex_illumination', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("illumination_type");
            $table->integer("manuskriptseiten_id")
                ->references("SeitenID")->on("manuskriptseiten")
                ->onDelete("cascade");
            $table->integer("paleocoran_manuscript_codex_id")
                ->references("id")->on("paleocoran_manuscript_codex")
                ->onDelete("cascade");
            $table->integer("sure_start");
            $table->integer("vers_start");
            $table->integer("wort_start");
            $table->integer("sure_ende");
            $table->integer("vers_ende");
            $table->integer("wort_ende");
            $table->string("line");
            $table->string("form");
            $table->string("function")->nullable();
            $table->string("color")->nullable();
            $table->string("special")->nullable();
            $table->string("text_arab")->nullable();
            $table->string("text_transliteration")->nullable();
            $table->boolean("modified")->nullable();
            $table->boolean("base_ink")->nullable();
            $table->integer("verse_separator")->nullable()
                ->references("id")->on("manuskriptseiten_verse_separators")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_codex_illumination');
    }
}
