<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranManuscriptCodexManuscriptsTable
 */
class CreatePaleocoranManuscriptCodexManuscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('paleocoran_manuscript_codex_manuscripts', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer("paleocoran_manuscript_codex_id")->unsigned();
            $table->foreign("paleocoran_manuscript_codex_id", "paleocoran_codex")
                ->references("id")
                ->on("paleocoran_manuscript_codex")
                ->onDelete("cascade");

            $table->integer("manuskript_id")->unsigned();

            // Range of manuscript, optional
            $table->string("manuskript_folio_start")->nullable();
            $table->char("manuskript_seite_start", 6)->nullable();
            $table->string("manuskript_folio_end")->nullable();
            $table->char("manuskript_seite_end", 6)->nullable();


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_manuscript_codex_manuscripts');
    }
}
