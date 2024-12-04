<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItIntertextEntryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_intertext_entry_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("language_id")->unsigned();
            $table->foreign("language_id")->references("id")->on("cc_translation_languages");
            $table->integer("intertext_id")->unsigned();
            $table->foreign("intertext_id")
                ->references("id")->on("it_intertext")
                ->onDelete('cascade');
            $table->integer("translator_id")->unsigned();
            $table->foreign("translator_id")->references("id")->on("cc_authors");
//            $table->text("entry_translation_reference", 65535)->nullable();
            $table->text("entry_translation", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['language_id', 'intertext_id', 'translator_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_intertext_entry_translations` COMMENT 'It represents the translation of an entry text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_intertext_entry_translations');
    }
}
