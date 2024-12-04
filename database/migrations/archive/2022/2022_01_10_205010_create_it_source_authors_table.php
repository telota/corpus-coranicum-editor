<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Intertexts\SourceAuthor;

class CreateItSourceAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_source_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string("author_name")->unique();
            $table->text("source_information_text", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `it_source_authors` COMMENT 'It represents the authors of sources.'");

        // add inital data

        $author = new SourceAuthor();
        $author->author_name = 'Anonymous';
        $author->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_source_authors');
    }
}
