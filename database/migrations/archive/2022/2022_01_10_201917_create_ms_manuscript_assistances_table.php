<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_assistances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->integer("assistance_id")->unsigned();
            $table->foreign("assistance_id")
                ->references("id")->on("cc_authors")
                ->onDelete('cascade');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['manuscript_id', 'assistance_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `ms_manuscript_assistances` COMMENT 'It represents the assistants of a certain manuscript.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_assistances');
    }
}
