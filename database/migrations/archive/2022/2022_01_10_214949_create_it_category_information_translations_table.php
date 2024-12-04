<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItCategoryInformationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_category_information_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("language_id")->unsigned();
            $table->foreign("language_id")->references("id")->on("cc_translation_languages");
            $table->integer("category_id")->unsigned();
            $table->foreign("category_id")
                ->references("id")->on("it_categories")
                ->onDelete('cascade');
            $table->integer("translator_id")->unsigned();
            $table->foreign("translator_id")->references("id")->on("cc_authors");
            $table->text("information_translation_reference", 65535)->nullable();
            $table->text("information_translation", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['language_id', 'category_id', 'translator_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_category_information_translations` COMMENT 'It represents the translation of a certain category information text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_category_information_translations');
    }
}
