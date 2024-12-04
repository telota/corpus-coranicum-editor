<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptColophonTextTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_colophon_text_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned();
            $table->foreign("language_id")->references("id")->on("cc_translation_languages");
            $table->integer('manuscript_id')->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->integer('translator_id')->unsigned();
            $table->foreign("translator_id")->references("id")->on("cc_authors");
            $table->text("colophon_text_translation_reference", 65535)->nullable();
            $table->text("colophon_text_translation", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(["language_id", "manuscript_id", "translator_id"], "unique_index");
        });

        DB::statement("ALTER TABLE `ms_manuscript_colophon_text_translations` COMMENT 'It represents the translation of a colophon text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_colophon_text_translations');
    }
}
