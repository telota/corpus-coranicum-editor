<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranCodexIlluminationColorsTable
 */
class CreatePaleocoranCodexIlluminationColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_codex_illumination_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("paleocoran_manuscript_codex_id")->unsigned();
            $table->foreign("paleocoran_manuscript_codex_id", "paleocoran_illumination_colors")
                ->references("id")
                ->on("paleocoran_manuscript_codex")
                ->onDelete("cascade");
            $table->string("color", 191);
            $table->unique(["paleocoran_manuscript_codex_id", "color"], "codex_illumination_colors");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_codex_illumination_colors');
    }
}
