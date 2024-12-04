<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItIntertextCollaboratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_intertext_collaborators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("intertext_id")->unsigned();
            $table->foreign("intertext_id")
                ->references("id")->on("it_intertext")
                ->onDelete('cascade');
            $table->integer("author_id")->unsigned();
            $table->foreign("author_id")
                ->references("id")->on("cc_authors")
                ->onDelete('cascade');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['intertext_id', 'author_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_intertext_collaborators` COMMENT 'It represents the collaborators of a certain intertext.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_intertext_collaborators');
    }
}
