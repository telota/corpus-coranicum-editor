<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItSourceInformationAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_source_information_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("info_author_id")->unsigned();
            $table->foreign("info_author_id")
                ->references("id")->on("cc_authors")
                ->onDelete('cascade');
            $table->integer("source_id")->unsigned();
            $table->foreign("source_id")
                ->references("id")->on("it_sources")
                ->onDelete('cascade');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['info_author_id', 'source_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_source_information_authors` COMMENT 'It represents the authors of a certain source information text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_source_information_authors');
    }
}
