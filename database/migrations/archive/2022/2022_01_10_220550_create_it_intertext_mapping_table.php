<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Umwelttexte\BelegstellenMapping;
use \App\Models\Intertexts\IntertextMapping;


class CreateItIntertextMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_intertext_mapping', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("intertext_id")->unsigned();
            $table->foreign("intertext_id")
                ->references("id")->on("it_intertext")
                ->onDelete('cascade');
            $table->decimal("sure_start", 3,0);
            $table->decimal("vers_start", 3,0);
            $table->decimal("sure_end", 3,0);
            $table->decimal("vers_end", 3,0);
            $table->index("intertext_id");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(["intertext_id", "sure_start", "vers_start", "sure_end", "vers_end"], "unique_index");
        });


        DB::statement("ALTER TABLE `it_intertext_mapping` ADD INDEX `mapping_index` (`sure_start` ASC, `vers_start` ASC, `sure_end` ASC, `vers_end` ASC)");
        DB::statement("ALTER TABLE `it_intertext_mapping` COMMENT 'Old table: belegstellen_mapping. It represents the mapping of a certain intertext. (Quran verses mapping)'");

        // transfer data from 'belegstellen_mapping' to 'it_intertext_mapping'

//        foreach(BelegstellenMapping::all() as $mapping)
//        {
//            if(\App\Models\Intertexts\Intertext::find($mapping->belegstelle)){
//                IntertextMapping::create([
//                    'intertext_id' => $mapping->belegstelle,
//                    'sure_start' => $mapping->sure_start,
//                    'vers_start' => $mapping->vers_start,
//                    'sure_end' => $mapping->sure_ende,
//                    'vers_end' => $mapping->vers_ende,
//                ]);
//            }
//        }

        DB::statement("INSERT INTO `it_intertext_mapping` (intertext_id, sure_start, vers_start, sure_end, vers_end)
  SELECT DISTINCT
    belegstelle,
    sure_start,
    vers_start,
    sure_ende,
    vers_ende
  FROM `belegstellen_mapping` bm
  WHERE EXISTS
  (
      SELECT id
      FROM `it_intertext` it
      WHERE it.id = bm.belegstelle
  );");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_intertext_mapping');
    }
}
