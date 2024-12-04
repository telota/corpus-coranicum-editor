<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItSourceInformationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_source_information_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("language_id")->unsigned();
            $table->foreign("language_id")->references("id")->on("cc_translation_languages");
            $table->integer("source_id")->unsigned();
            $table->foreign("source_id")
                ->references("id")->on("it_sources")
                ->onDelete('cascade');
            $table->integer("translator_id")->unsigned();
            $table->foreign("translator_id")->references("id")->on("cc_authors");
            $table->text("information_translation_reference", 65535)->nullable();
            $table->text("information_translation", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['language_id', 'source_id', 'translator_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_source_information_translations` COMMENT 'It represents the translation of a certain source information text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_source_information_translations');
    }
}
