<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use \App\Models\Manuscripts\ManuscriptPage;
use App\Models\Manuscripts\ManuscriptPageMapping;
use App\Models\Manuskripte\ManuskriptseitenMapping;

class PopulateManuscriptPageMappings extends Migration
{
    private function renameColumns()
    {
        $renamings = [
            "sure_start" => "sura_start",
            "sure_end" => "sura_end",
            "vers_start" => "verse_start",
            "vers_end" => "verse_end",
        ];

        foreach ($renamings as $from => $to) {
            Log::info("Rename {$from} to {$to}.");
            Schema::table(
                'ms_manuscript_pages_mapping',
                function (Blueprint $table) use ($from, $to) {
                    $table->renameColumn($from, $to);
                }
            );
        }
    }

    private function migrateMappings()
    {

        foreach (ManuskriptseitenMapping::orderBy('id')->get() as $mapping) {
            if (ManuscriptPage::find($mapping->manuskriptseite)) {
                $copy = ManuscriptPageMapping::create([
                    'created_by' => "DATA_MIGRATION",
                    'updated_by' => "DATA_MIGRATION",
                    'manuscript_page_id' => $mapping->manuskriptseite,
                    'sura_start' => $mapping->sure_start,
                    'verse_start' => $mapping->vers_start,
                    'word_start' => $mapping->wort_start,
                    'sura_end' => $mapping->sure_ende,
                    'verse_end' => $mapping->vers_ende,
                    'word_end' => $mapping->wort_ende,
                ]);

                $copy->id = $mapping->id;
                $copy->save();
            } else {
                Log::info(
                    "No manuscript page found for mapping id: {$mapping->id} and manuscript page id: {$mapping->manuskriptseite}."
                );
            }
        }
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Log::info("Starting manuscript page mapping migration");
        DB::transaction(function () {
            $this->renameColumns();
            ManuscriptPageMapping::truncate();

            $this->migrateMappings();
            $increment = ManuscriptPageMapping::max('id') + 1;
            DB::statement("ALTER TABLE ms_manuscript_pages_mapping AUTO_INCREMENT =  {$increment}");
        });
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
