<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItIntertextAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_intertext_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("intertext_id")->unsigned();
            $table->foreign("intertext_id")
                ->references("id")->on("it_intertext")
                ->onDelete('cascade');
            $table->integer("author_id")->unsigned();
            $table->foreign("author_id")
                ->references("id")->on("cc_authors")
                ->onDelete("cascade");
            $table->string("addition")->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['intertext_id', 'author_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_intertext_authors` COMMENT 'Old table: belegstellen_bearbeiter. It represents the authors of a certain intertext.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_intertext_authors');
    }
}
