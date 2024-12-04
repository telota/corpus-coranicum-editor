<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaleocoranCodexRulingSystemsTable
 */
class CreatePaleocoranCodexRulingSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_codex_ruling_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("paleocoran_manuscript_codex_id")->unsigned();
            $table->foreign("paleocoran_manuscript_codex_id", "paleocoran_ruling_systems")
                ->references("id")->on("paleocoran_manuscript_codex")
                ->onDelete("cascade");
            $table->string("ruling_system");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paleocoran_codex_ruling_systems');
    }
}
