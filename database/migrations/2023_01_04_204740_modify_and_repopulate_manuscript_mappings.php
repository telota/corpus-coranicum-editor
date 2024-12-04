<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use \App\Models\Manuskripte\ManuskriptMapping;
use \App\Models\Manuscripts\ManuscriptMapping;
use \App\Models\Manuscripts\ManuscriptNew;


class ModifyAndRepopulateManuscriptMappings extends Migration
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
            Log::info("Rename " . $from . " to  " . $to);
            Schema::table(
                'ms_manuscript_mapping',
                function (Blueprint $table) use ($from, $to) {
                    $table->renameColumn($from, $to);
                }
            );
        }
    }

    private function migrateMappings()
    {

        foreach (ManuskriptMapping::orderBy('id')->get() as $mapping) {
            if (ManuscriptNew::find($mapping->manuskript)) {
                $copy = ManuscriptMapping::create([
                    'created_by' => "DATA_MIGRATION",
                    'manuscript_id' => $mapping->manuskript,
                    'sura_start' => $mapping->sure_start,
                    'verse_start' => $mapping->vers_start,
                    'word_start' => $mapping->wort_start,
                    'sura_end' => $mapping->sure_ende,
                    'verse_end' => $mapping->vers_ende,
                    'word_end' => $mapping->wort_ende,
                ]);

                $copy->id = $mapping->id;
                $copy->save();
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
        DB::transaction(function () {
            $this->renameColumns();
            ManuscriptMapping::truncate();

            $this->migrateMappings();
            $increment = ManuscriptMapping::max('id') + 1;
            DB::statement("ALTER TABLE ms_manuscript_mapping AUTO_INCREMENT =  {$increment}");
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
