<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptReadingSignsFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_reading_signs_functions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->nullable()->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->string("reading_sign_function")->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['manuscript_id', 'reading_sign_function'], "unique_index");
        });

        DB::statement("ALTER TABLE `ms_manuscript_reading_signs_functions` COMMENT 'It represents the function of reading signs of a certain manuscript.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_reading_signs_functions');
    }
}
