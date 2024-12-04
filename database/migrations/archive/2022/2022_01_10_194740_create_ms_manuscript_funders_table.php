<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptFundersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_funders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->integer("funder_id")->unsigned();
            $table->foreign("funder_id")
                ->references("id")->on("ms_funders")
                ->onDelete('cascade');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['manuscript_id', 'funder_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `ms_manuscript_funders` COMMENT 'It represents the funders of a certain manuscript.'");
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_manuscript_funders');
    }
}
