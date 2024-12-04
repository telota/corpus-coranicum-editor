<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Umwelttexte\Belegstelle;
use \App\Models\Intertexts\Intertext;

class CreateItIntertextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_intertext', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("source_id")->nullable()->unsigned();
            $table->foreign("source_id")->references("id")->on("it_sources");
            $table->string("source_chapter")->nullable();
            $table->integer("language_id")->nullable()->unsigned();
            $table->foreign("language_id")->references("id")->on("it_original_languages");
            $table->string("language_direction", 3)->nullable();
            $table->text("source_text_original", 65535)->nullable();
            $table->text("source_text_transcription", 65535)->nullable();
            $table->integer("script_id")->nullable()->unsigned();
            $table->foreign("script_id")->references("id")->on("it_scripts");
            $table->string("place")->nullable();
            $table->string("intertext_date_start")->nullable();
            $table->string("intertext_date_end")->nullable();
            $table->text("source_text_edition", 65535)->nullable();
            $table->text("explanation_about_edition", 65535)->nullable();
            $table->text("tuk_reference", 65535)->nullable();
            $table->text("quran_text", 65535)->nullable();
            $table->text("entry", 65535)->nullable();
            $table->tinyInteger("is_online")->default('0');
            $table->integer("category_id")->nullable()->unsigned();
            $table->foreign("category_id")->references("id")->on("it_categories");
            $table->text("keyword_persons", 65535)->nullable();
            $table->text("keyword_places", 65535)->nullable();
            $table->text("keyword_others", 65535)->nullable();
            $table->text("keyword", 65535)->nullable();
            $table->string("doi")->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->timestamp("published_at")->nullable();

            $table->unique(['source_id', 'source_chapter'], "unique_index");
            $table->index("is_online");
        });

        DB::statement("ALTER TABLE `it_intertext` COMMENT 'Old table: belegstellen. It represents the metadata of intertexts.'");

        // transfer data from 'belegstellen' to 'it_intertext'

//        foreach(Belegstelle::all() as $intertext)
//        {
//            Intertext::create([
//                'id' => $intertext->id,
//                'language_direction' => $intertext->Sprache_richtung,
//                'source_text_original' => $intertext->Originalsprache,
//                'source_text_transcription' => $intertext->Transkription,
//                'place' => $intertext->Ort,
//                'source_text_edition' => $intertext->Edition,
//                'explanation_about_edition' => $intertext->HinweiseaufEdition,
//                'tuk_reference' => $intertext->Identifikator,
//                'quran_text' => $intertext->TextstelleKoran,
//                'entry' => $intertext->Anmerkungen,
//                'keyword_persons' => $intertext->SchlagwortPersonen,
//                'keyword_places' => $intertext->SchlagwortOrte,
//                'keyword_others' => $intertext->SchlagwortSonst,
//                'keyword' => $intertext->Stichwort,
//                'updated_by' => $intertext->lastAuthor,
//                'category_id' => $intertext->kategorie + 1,
//                'created_at' => $intertext->created_at,
//                'updated_at' => $intertext->updated_at
//            ]);
//        }

        DB::statement("INSERT INTO `it_intertext` (id, language_direction, source_text_original, source_text_transcription, place,
                          source_text_edition,
                          explanation_about_edition, tuk_reference, quran_text, entry, keyword_persons, keyword_places,
                          keyword_others, keyword, updated_by, category_id, created_at, updated_at)
  SELECT
    ID,
    Sprache_richtung,
    Originalsprache,
    Transkription,
    Ort,
    Edition,
    HinweiseaufEdition,
    Identifikator,
    TextstelleKoran,
    Anmerkungen,
    SchlagwortPersonen,
    SchlagwortOrte,
    SchlagwortSonst,
    Stichwort,
    lastAuthor,
    kategorie + 1,
    created_at,
    updated_at
  FROM `belegstellen`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_intertext');
    }
}
