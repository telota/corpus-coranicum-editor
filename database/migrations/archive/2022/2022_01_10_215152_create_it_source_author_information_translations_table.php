<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItSourceAuthorInformationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_source_author_information_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("language_id")->unsigned();
            $table->foreign("language_id", "it_source_author_information_translations_foreign_1")->references("id")->on("cc_translation_languages");
            $table->integer("source_author_id")->unsigned();
            $table->foreign("source_author_id", "it_source_author_information_translations_foreign_2")
                ->references("id")->on("it_source_authors")
                ->onDelete('cascade');
            $table->integer("translator_id")->unsigned();
            $table->foreign("translator_id", "it_source_author_information_translations_foreign_3")->references("id")->on("cc_authors");
            $table->text("information_translation_reference", 65535)->nullable();
            $table->text("information_translation", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['language_id', 'source_author_id', 'translator_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_source_author_information_translations` COMMENT 'It represents the translation of a certain source author information text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_source_author_information_translations');
    }
}
