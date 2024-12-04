<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptReadingSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_reading_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete("cascade");
            $table->integer("reading_sign_id")->unsigned();
            $table->foreign("reading_sign_id")
                ->references("id")->on("ms_reading_signs")
                ->onDelete("cascade");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['manuscript_id', 'reading_sign_id']);
        });

        DB::statement("ALTER TABLE `ms_manuscript_reading_signs` COMMENT 'It represents the reading signs or vowel signs of a certain manuscript.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_manuscript_reading_signs');
    }
}
