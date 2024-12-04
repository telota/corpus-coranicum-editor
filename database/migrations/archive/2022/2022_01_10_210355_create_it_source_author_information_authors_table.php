<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItSourceAuthorInformationAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_source_author_information_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("info_author_id")->unsigned();
            $table->foreign("info_author_id")
                ->references("id")->on("cc_authors")
                ->onDelete('cascade');
            $table->integer("author_id")->unsigned();
            $table->foreign("author_id")
                ->references("id")->on("it_source_authors")
                ->onDelete('cascade');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['info_author_id', 'author_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_source_author_information_authors` COMMENT 'It represents the authors of a certain source author information text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_source_author_information_authors');
    }
}
