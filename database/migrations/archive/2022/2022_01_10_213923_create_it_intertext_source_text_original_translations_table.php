<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItIntertextSourceTextOriginalTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_intertext_source_text_original_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("language_id")->unsigned();
            $table->foreign("language_id", "it_intertext_source_text_original_translations_foreign_1")->references("id")->on("cc_translation_languages");
            $table->integer("intertext_id")->unsigned();
            $table->foreign("intertext_id", "it_intertext_source_text_original_translations_foreign_2")
                ->references("id")->on("it_intertext")
                ->onDelete('cascade');
            $table->integer("translator_id")->unsigned();
            $table->foreign("translator_id", "it_intertext_source_text_original_translations_foreign_3")->references("id")->on("cc_authors");
            $table->text("source_text_translation_reference", 65535)->nullable();
            $table->text("source_text_translation", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['language_id', 'intertext_id', 'translator_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_intertext_source_text_original_translations` COMMENT 'It represents the translation of an original text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_intertext_source_text_original_translations');
    }
}
