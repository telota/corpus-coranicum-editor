<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RemovePaleocoranTables extends Migration
{
    private $tablesToRemove = [

        "paleocoran_manuscript_codex_mappings",
        "paleocoran_codex_classification",
        "paleocoran_codex_defects",
        "paleocoran_codex_illumination",
        "paleocoran_codex_illumination_colors",
        "paleocoran_codex_illumination_decorative_repertoire",
        "paleocoran_codex_limit_lines",
        "paleocoran_codex_page_design_formula_agreement_of_aya",
        "paleocoran_codex_page_design_formula_chapter_designation",
        "paleocoran_codex_page_design_formula_sequence_of_numbering",
        "paleocoran_codex_page_design_heading_type",
        "paleocoran_codex_page_design_justification",
        "paleocoran_codex_paleography_colors",
        "paleocoran_codex_quire_composition",
        "paleocoran_codex_quire_types",
        "paleocoran_codex_ruling_systems",
        "paleocoran_codex_skins",
        "paleocoran_manuscript_codex_manuscripts",
        "paleocoran_users",
        "paleocoran_manuscript_codex",
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tablesToRemove as $table) {
            Schema::drop($table);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tablesToRemove as $table) {
            Schema::create($table, function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->timestamps();
            });
            ($table);
        }
    }
}
