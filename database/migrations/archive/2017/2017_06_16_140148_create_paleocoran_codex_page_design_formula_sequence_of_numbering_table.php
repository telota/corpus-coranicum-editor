<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranCodexPageDesignFormulaSequenceOfNumberingTable
 */
class CreatePaleocoranCodexPageDesignFormulaSequenceOfNumberingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_codex_page_design_formula_sequence_of_numbering', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("paleocoran_manuscript_codex_id")->unsigned();
            $table->foreign("paleocoran_manuscript_codex_id", "paleocoran_sequence_numbering")
                ->references("id")->on("paleocoran_manuscript_codex")
                ->onDelete("cascade");
            $table->string("sequence")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_codex_page_design_formula_sequence_of_numbering');
    }
}
