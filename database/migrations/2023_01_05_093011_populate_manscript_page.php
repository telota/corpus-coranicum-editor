<?php

use App\Models\Manuscripts\ManuscriptPage;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuscripts\ManuscriptPageMapping;
use App\Models\Manuskripte\Manuskript;
use App\Models\Manuskripte\Manuskriptseite;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PopulateManscriptPage extends Migration
{
    private $lastOldId;

    public static $is_online_mapper = [
        "ja" => 2,
        "ohneBild" => 1,
        "nein" => 0,
    ];

    private function createNewManuscriptPage($oldPage)
    {
        Log::info(
            "Working on page: id: '{$oldPage->SeitenID}', Folio: '{$oldPage->Folio}', Seite: '{$oldPage->Seite}'..."
        );

        $new = ManuscriptPage::create([
            'created_by' => "DATA_MIGRATION",
            'manuscript_id' => $oldPage->ManuskriptID,
            'folio' => $oldPage->Folio,
            'page_side' => $oldPage->Seite,
            'is_online' => self::$is_online_mapper[$oldPage->webtauglich] ?? 0,
        ]);

        $new->id = $oldPage->SeitenID + $this->lastOldId;

        $new->save();
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::info("Starting migration of manuscript pages");

        Log::info("Deleting Manuscript Pages and entities that depend on them");
        ManuscriptPageImage::truncate();
        ManuscriptPageMapping::truncate();
        ManuscriptPage::all()->each(function ($item) {
            $item->delete();
        });
        DB::statement("ALTER TABLE ms_manuscript_pages AUTO_INCREMENT =  1");

        Log::info("Creating new manuscript pages");
        $oldPages = Manuskriptseite::orderBy('SeitenID')->get();
        $this->lastOldId = $oldPages->last()->SeitenID;

        DB::transaction(function () use ($oldPages) {
            foreach ($oldPages as $oldPage) {
                if (Manuskript::find($oldPage->ManuskriptID)) {
                    $this->createNewManuscriptPage($oldPage);
                } else {
                    Log::info(
                        "No manuscript with id '{$oldPage->ManuskriptID}' found for page {$oldPage->SeitenID}. Skipping..."
                    );
                }
            }
            foreach (ManuscriptPage::all() as $page) {
                $page->id = $page->id - $this->lastOldId;
                $page->updated_by = "DATA_MIGRATION";
                $page->save();
            }
        });
        $increment = ManuscriptPage::max('id') + 1;
        DB::statement("ALTER TABLE ms_manuscript_pages AUTO_INCREMENT =  {$increment}");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
