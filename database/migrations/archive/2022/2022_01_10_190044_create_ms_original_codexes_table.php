<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\ManuscriptOriginalCodex;

class CreateMsOriginalCodexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_original_codexes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('original_codex_name', 500)->nullable()->unique();
            $table->integer('supercategory')->nullable()->unsigned();
            $table->foreign("supercategory")
                ->references("id")->on("ms_original_codexes");
            $table->integer('script_style_id')->nullable()->unsigned();
            $table->foreign("script_style_id")
                ->references("id")->on("ms_script_styles");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->index('original_codex_name');
            $table->unique(['supercategory', 'original_codex_name']);
        });

        DB::statement("ALTER TABLE `ms_original_codexes` COMMENT 'It represents the category of manuscripts.'");

        // add initial data

        $originalCodexesData =
            [
                'keine', 'Blauer Koran'
            ];

        foreach ($originalCodexesData as $datum) {
            $author = new ManuscriptOriginalCodex();
            $author->original_codex_name = $datum;
            $author->supercategory = null;
            $author->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_original_codexes');
    }
}
