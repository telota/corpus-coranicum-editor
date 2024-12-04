<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuskripte\ManuskriptMapping;
use \App\Models\Manuscripts\ManuscriptMapping;

class CreateMsManuscriptMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_mapping', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->nullable()->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->decimal("sure_start", 3,0)->nullable();
            $table->decimal("vers_start", 3,0)->nullable();
            $table->decimal("word_start", 3,0)->nullable();
            $table->decimal("sure_end", 3,0)->nullable();
            $table->decimal("vers_end", 3,0)->nullable();
            $table->decimal("word_end", 3,0)->nullable();
            $table->index("manuscript_id");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
//            $table->unique(["manuscript_id", "sure_start", "vers_start", "word_start", "sure_end", "vers_end", "word_end"], "unique_index"); //too many duplicates in the old table manuskript_mapping to copy
        });


        DB::statement("ALTER TABLE `ms_manuscript_mapping` ADD INDEX `mapping_index` (`sure_start` ASC, `vers_start` ASC, `word_start` ASC, `sure_end` ASC, `vers_end` ASC, `word_end` ASC)");
        DB::statement("ALTER TABLE `ms_manuscript_mapping` COMMENT 'Old table: manuskript_mapping. It represents mapping table for manuscript, in contrast to ms_manuscript_pages_mapping the datasets are summarized.'");

        // transfer data from 'manuskript_mapping' to 'ms_manuscript_mapping'

        foreach(ManuskriptMapping::all() as $mapping)
        {
            if (\App\Models\Manuscripts\ManuscriptNew::find($mapping->manuskript)) {
                ManuscriptMapping::create([
                    'manuscript_id' => $mapping->manuskript,
                    'sure_start' => $mapping->sure_start,
                    'vers_start' => $mapping->vers_start,
                    'word_start' => $mapping->wort_start,
                    'sure_end' => $mapping->sure_ende,
                    'vers_end' => $mapping->vers_ende,
                    'word_end' => $mapping->wort_ende,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_mapping');
    }
}
