<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuskripte\Manuskriptseite;
use \App\Models\Manuscripts\ManuscriptPage;

class CreateMsManuscriptPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->nullable()->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->integer("folio")->nullable(); //folio
            $table->string("page_side")->nullable(); //seite
            $table->tinyInteger("is_online")->default('0'); //webtauglich
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
//            $table->unique(['manuscript_id', 'folio', 'page_side'], "unique_index"); // too many duplicates in the old table manuskriptseiten to copy
            $table->index("is_online");
        });

        DB::statement("ALTER TABLE `ms_manuscript_pages` COMMENT 'Old table: manuskriptseiten. It represents the manuscript pages of a certain manuscript.'");

        // copy pages with numeric folios

//        foreach(Manuskriptseite::where('Folio', 'regexp', '^[0-9]+$')->get() as $manuscriptPage)
//        {
//            ManuscriptPage::create([
//                'id' => $manuscriptPage->SeitenID,
//                'manuscript_id' => $manuscriptPage->ManuskriptID,
//                'folio' => abs(intval($manuscriptPage->Folio)),
//                'page_side' => $manuscriptPage->Seite
//            ]);
//        }

        DB::statement("INSERT INTO `ms_manuscript_pages` (id, manuscript_id, folio, page_side)
  SELECT
    SeitenID,
    ManuskriptID,
    CAST(Folio AS UNSIGNED),
    Seite
  FROM `manuskriptseiten` ms
    INNER JOIN `ms_manuscript` m ON ms.ManuskriptID = m.id
  WHERE ms.Folio REGEXP '^[0-9]+$';");

        // copy pages with non-numeric folios

//        foreach (Manuskriptseite::where('Folio', 'regexp', '^[a-z]+$')->get() as $manuscriptPage) {
//            ManuscriptPage::create([
//                'id' => $manuscriptPage->SeitenID,
//                'manuscript_id' => $manuscriptPage->ManuskriptID,
//                'page_side' => $manuscriptPage->Seite
//            ]);
//        }

        DB::statement("INSERT INTO `ms_manuscript_pages` (id, manuscript_id, page_side)
  SELECT
    SeitenID,
    ManuskriptID,
    Seite
  FROM `manuskriptseiten` ms
    INNER JOIN `ms_manuscript` m ON ms.ManuskriptID = m.id
  WHERE ms.Folio REGEXP '^[a-z]+$';");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_pages');
    }
}
