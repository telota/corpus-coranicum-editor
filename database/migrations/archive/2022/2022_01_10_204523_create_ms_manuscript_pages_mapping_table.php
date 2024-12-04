<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuskripte\ManuskriptseitenMapping;
use \App\Models\Manuscripts\ManuscriptPageMapping;

class CreateMsManuscriptPagesMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_pages_mapping', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_page_id")->nullable()->unsigned();
            $table->foreign("manuscript_page_id")
                ->references("id")->on("ms_manuscript_pages")
                ->onDelete('cascade');
            $table->decimal("sure_start", 3,0)->nullable();
            $table->decimal("vers_start", 3,0)->nullable();
            $table->decimal("word_start", 3,0)->nullable();
            $table->decimal("sure_end", 3,0)->nullable();
            $table->decimal("vers_end", 3,0)->nullable();
            $table->decimal("word_end", 3,0)->nullable();
            $table->index("manuscript_page_id");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
//            $table->unique(["manuscript_id", "sure_start", "vers_start", "word_start", "sure_end", "vers_end", "word_end"], "unique_index"); //too many duplicates in the old table manuskript_mapping to copy
        });


        DB::statement("ALTER TABLE `ms_manuscript_pages_mapping` ADD INDEX `mapping_index` (`sure_start` ASC, `vers_start` ASC, `word_start` ASC, `sure_end` ASC, `vers_end` ASC, `word_end` ASC)");
        DB::statement("ALTER TABLE `ms_manuscript_pages_mapping` COMMENT 'Old table: manuskriptseiten_mapping. It represents a mapping table for manuscript pages (Quran words mapping).'");

        // transfer data from 'manuskript_mapping' to 'ms_manuscript_mapping'

        foreach(ManuskriptseitenMapping::all() as $mapping)
        {
            if(\App\Models\Manuscripts\ManuscriptPage::find($mapping->manuskriptseite)) {
                ManuscriptPageMapping::create([
                    'manuscript_page_id' => $mapping->manuskriptseite,
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
        Schema::drop('ms_manuscript_pages_mapping');
    }
}
