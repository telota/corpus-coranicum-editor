<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptAttributedToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_attributed_to', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete("cascade");
            $table->integer("attributed_to_id")->unsigned();
            $table->foreign("attributed_to_id")
                ->references("id")->on("ms_attributed_to")
                ->onDelete("cascade");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['manuscript_id', 'attributed_to_id'], "unique_index");
        });

        DB::statement("ALTER TABLE `ms_manuscript_attributed_to` COMMENT 'It represents the person whom a certain manuscript attributed.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_manuscript_attributed_to');
    }
}

