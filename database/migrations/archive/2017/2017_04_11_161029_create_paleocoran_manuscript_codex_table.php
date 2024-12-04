<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranManuscriptCodexTable
 */
class CreatePaleocoranManuscriptCodexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_manuscript_codex', function (Blueprint $table) {
            $table->engine='innodb ROW_FORMAT=COMPRESSED';
            $table->increments('id');
            $table->timestamps();

            $table->string("name");
            $table->text("storage")->nullable();
            $table->text("origin")->nullable();

            $table->float("dimensions_outer_max_width")->nullable();
            $table->float("dimensions_outer_max_height")->nullable();
            $table->float("dimensions_inner_max_width")->nullable();
            $table->float("dimensions_inner_max_height")->nullable();

            $table->string("orientation")->nullable();

            $table->float("lines_per_page")->nullable();

            $table->text("notes")->nullable();

            $table->string("colophon_scribe")->nullable();
            $table->string("colophon_patron")->nullable();
            $table->string("colophon_date")->nullable();
            $table->string("colophon_place")->nullable();

            $table->string("waqf_donor")->nullable();
            $table->string("waqf_beneficiary_institution")->nullable();
            $table->string("waqf_date")->nullable();
            $table->string("waqf_citation")->nullable();

            $table->text("classification_notes")->nullable();
            $table->text("paleographic_description")->nullable();
            $table->text("corrections")->nullable();

            $table->string("material")->nullable();

            // Skin -> Has many

            $table->string("grain")->nullable();
            $table->string("thickness")->nullable();

            // defects -> has many

            $table->text("pigmentation")->nullable();
            $table->text("hair_follicles")->nullable();
            $table->text("animal_species")->nullable();
            $table->text("skin_treatment")->nullable();

            $table->integer("quires_preserved")->nullable();
            $table->integer("quires_estimated")->nullable();
            $table->string("quire_correspondant_folding")->nullable();
            $table->string("membrane_disposition_gregory")->nullable();
            $table->string("membrane_disposition_outer_side")->nullable();
            $table->string("membrane_disposition_central_bifolium")->nullable();

            $table->string("ruling_means_of_ruling")->nullable();
            $table->text("ruling_pricking")->nullable();
            $table->string("ruling_line_ruling_type")->nullable();
            $table->double("ruling_line_ruling_measure")->nullable();

            $table->string("ink_category")->nullable();
            $table->text("ink_corrections_and_additions")->nullable();
            $table->text("ink_pigments_text")->nullable();
            $table->text("ink_pigments_vowels")->nullable();
            $table->text("ink_pigments_ornaments")->nullable();
            $table->text("ink_other_components")->nullable();
            $table->text("ink_analysis")->nullable();

            $table->boolean("page_design_margin")->nullable();
            $table->string("page_design_writing_lines")->nullable();
            $table->text("page_design_interlinear_space")->nullable();
            $table->text("page_design_other_remarks")->nullable();
            //$table->string("page_design_heading_title")->nullable();
            $table->text("page_design_heading_title_type_of_script")->nullable();
            $table->text("page_design_heading_title_color")->nullable();
            $table->text("page_design_heading_title_formula_title_relation")->nullable();
            $table->text("page_design_heading_title_formula_additional_information")->nullable();

            $table->string("illumination_quality_of_execution_rating")->nullable();
            $table->text("illumination_quality_of_execution_comment")->nullable();

            $table->text("comment_variant_readings")->nullable();
            $table->text("comment_variants_in_orthography")->nullable();
            $table->text("comment_verse_separators")->nullable();

            $table->text("bibliography")->nullable();

            $table->boolean("release")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_manuscript_codex');
    }
}
