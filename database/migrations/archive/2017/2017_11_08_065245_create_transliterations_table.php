<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransliterationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transliterations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer("manuscript_page_id");
            $table->foreign("manuscript_page_id", "transliterations")
                ->references("SeitenID")
                ->on("manuskriptseiten")
                ->onDelete("cascade");
            $table->integer('linenumber');
            $table->text('HTML');
            $table->text('XML');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transliterations');
    }
}
