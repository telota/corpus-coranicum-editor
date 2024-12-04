<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranManuscriptCodexMappingsTable
 */
class CreatePaleocoranManuscriptCodexMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_manuscript_codex_mappings', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer("paleocoran_manuscript_codex_id")->unsigned();
            $table->foreign("paleocoran_manuscript_codex_id", "paleocoran_codex_mapping")
                ->references("id")->on("paleocoran_manuscript_codex")
                ->onDelete("cascade");

            $table->integer("codex_manuscript_mapping_id")->unsigned();
            $table->foreign("codex_manuscript_mapping_id", "paleocoran_codex_manuscript_mapping")
                ->references("id")->on("paleocoran_manuscript_codex_manuscripts")
                ->onDelete("cascade");

            $table->integer("sure_start");
            $table->integer("vers_start");
            $table->integer("wort_start")->nullable();

            $table->integer("sure_end");
            $table->integer("vers_end");
            $table->integer("wort_end")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_manuscript_codex_mappings');

    }
}
