<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string("source_name")->unique();
            $table->integer("author_id")->unsigned();
            $table->foreign("author_id")->references("id")->on("it_source_authors");
            $table->text("source_information_text", 65535)->nullable();
            $table->tinyInteger("is_valid_source")->default('0');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['source_name', 'author_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_sources` COMMENT 'It represents the sources of intertexts. It can be a book, poetry, letter, and other types of text.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_sources');
    }
}
