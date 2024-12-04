<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Umwelttexte\BelegstellenBilder;
use \App\Models\Intertexts\IntertextIllustration;

class CreateItIntertextIllustrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_intertext_illustrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("intertext_id")->unsigned();
            $table->foreign("intertext_id")->references("id")->on("it_intertext");
            $table->string("image_link")->unique();
            $table->text("licence_for_image", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['intertext_id', 'image_link'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_intertext_illustrations` COMMENT 'Old table: belegstellen_bilder. It represents the image of a certain intertext.'");

        // transfer data from 'belegstellen_bilder' to 'it_intertext_illustrations'

//        foreach(BelegstellenBilder::all() as $illustration)
//        {
//            if(\App\Models\Intertexts\Intertext::find($illustration->belegstelle)) {
//                $newIllustration = IntertextIllustration::create([
//                    'intertext_id' => $illustration->belegstelle,
//                    'image_link' => $illustration->bildlink,
//                    'licence_for_image' => $illustration->bildnachweis
//                ]);
//                $newIllustration->created_at = $illustration->created_at;
//                $newIllustration->updated_at = $illustration->updated_at;
//                $newIllustration->save();
//            }
//
//        }

        DB::statement("INSERT INTO `it_intertext_illustrations` (id, intertext_id, image_link, licence_for_image, created_at, updated_at)
  SELECT
    id,
    belegstelle,
    bildlink,
    bildnachweis,
    created_at,
    updated_at
  FROM `belegstellen_bilder` bb
  WHERE EXISTS
  (
      SELECT id
      FROM `it_intertext` it
      WHERE it.id = bb.belegstelle
  );");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_intertext_illustrations');
    }
}
