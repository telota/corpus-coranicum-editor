<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuskripte\Manuskript;
use \App\Models\Manuscripts\ManuscriptNew;

class CreateMsManuscriptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('call_number')->nullable();
            $table->integer('place_id')->nullable()->unsigned(); //AufbewahrungsortId
            $table->foreign("place_id")->references("id")->on("ms_places");
            $table->tinyInteger('is_online');
            $table->string('dimensions')->nullable();
            $table->string('format_text_field')->nullable();
            $table->string('number_of_lines')->nullable();
            $table->integer('number_of_folios')->nullable();
            $table->text('carbon_dating', 65535)->nullable();
            $table->integer('date_start')->nullable();
            $table->integer('date_end')->nullable();
            $table->string('writing_surface')->nullable();
            $table->integer('original_codex_id')->nullable()->unsigned();
            $table->foreign("original_codex_id")->references("id")->on("ms_original_codexes");
            $table->string('palimpsest')->nullable();
            $table->mediumText('palimpsest_text')->nullable();
            $table->string('sajda_signs')->nullable();
            $table->mediumText('sajda_signs_text')->nullable();
            $table->string('colophon')->nullable();
            $table->mediumText('colophon_text')->nullable();
            $table->date('colophon_date_start', 65535)->nullable();
            $table->date('colophon_date_end', 65535)->nullable();
            $table->string('doi')->nullable();
            $table->text('credit_line_image', 65535)->nullable();
            $table->text('codicology', 65535)->nullable();
            $table->text('paleography', 65535)->nullable();
            $table->text('commentary_internal', 65535)->nullable();
            $table->text('ornaments', 65535)->nullable();
            $table->text('catalogue_entry', 65535)->nullable();
            $table->mediumText("transliteration")->nullable(); //transliteration_alt
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->index('is_online');
            $table->unique(['call_number', 'place_id']);
        });

        DB::statement("ALTER TABLE `ms_manuscript` COMMENT 'Old table: manuskript. It represents manuscript metadata.'");

        // transfer data from 'manuskript' to 'ms_manuscript'

//        $lastId = DB::table('manuskript')->orderBy('ID', 'DESC')->first()->ID;
//
//        foreach(Manuskript::all() as $manuscript)
//        {
//            $newManuscript = ManuscriptNew::create([
//                'credit_line_image' => $manuscript->Bildnachweis,
//                'commentary_internal' => $manuscript->Kommentar_intern,
//                'catalogue_entry' => $manuscript->Kommentar,
//                'codicology' => $manuscript->Kodikologie,
//                'paleography' => $manuscript->Palaographie,
//                'transliteration' => $manuscript->transliteration_alt
//            ]);
//
//            $newManuscript->id = $manuscript->ID + $lastId;
//            $newManuscript->save();
//        }
//
//        foreach(ManuscriptNew::all() as $newManuscript) {
//            $newManuscript->id = $newManuscript->id - $lastId;
//            $newManuscript->save();
//        }


        DB::statement("INSERT INTO `ms_manuscript` (id, credit_line_image,
                           commentary_internal, catalogue_entry, codicology, paleography, transliteration)
  SELECT
    ID,
    Bildnachweis,
    Kommentar_intern,
    Kommentar,
    Kodikologie,
    Palaographie,
    transliteration_alt
  FROM `manuskript`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_manuscript');
    }
}
