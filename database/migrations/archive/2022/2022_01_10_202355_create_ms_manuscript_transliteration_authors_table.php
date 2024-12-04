<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptTransliterationAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_transliteration_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->integer("transliteration_author_id")->unsigned();
            $table->foreign("transliteration_author_id", "ms_manuscript_transliteration_authors_foreign_2")
                ->references("id")->on("cc_authors")
                ->onDelete('cascade');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['manuscript_id', 'transliteration_author_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `ms_manuscript_transliteration_authors` COMMENT 'It represents transliteration authors of a certain manuscript.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_transliteration_authors');
    }
}
