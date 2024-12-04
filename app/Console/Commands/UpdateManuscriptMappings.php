<?php

namespace App\Console\Commands;

use App\Library\ManuscriptMapper;
use App\Library\Verse;
use App\Library\VerseLimit;
use App\Models\Koranstelle;
use App\Models\Manuscripts\ManuscriptMapping;
use App\Models\Manuscripts\ManuscriptPageMapping;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class UpdateManuscriptMappings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-manuscript-mappings {manuscript_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the manuscript mappings';

    public function updateSingleManuscript(ManuscriptMapper $mapper, $manuscriptId)
    {
        $mappings = ManuscriptPageMapping::wherehas('manuscriptPage', function (Builder $query) use ($manuscriptId) {
            $query->where('manuscript_id', "=", $manuscriptId);
        })->where('sura_start', "!=", 999)
            ->where('verse_start', "!=", 999)
            ->where('sura_end', "!=", 999)
            ->where('verse_end', "!=", 999)
            ->get();

        $verseMappings = $mapper->makeMappings($mappings, $manuscriptId);

        ManuscriptMapping::where('manuscript_id', "=", $manuscriptId)->delete();

        ManuscriptMapping::insert($verseMappings);

    }

    public function updateAllManuscripts(ManuscriptMapper $mapper)
    {

        $oldMappings = ManuscriptMapping::all()
            ->groupBy('manuscript_id');


        $pageMappings = ManuscriptPageMapping::where('sura_start', "!=", 999)
            ->where('verse_start', "!=", 999)
            ->where('sura_end', "!=", 999)
            ->where('verse_end', "!=", 999)
            ->with('manuscriptPage')->get()
            ->groupBy('manuscriptPage.manuscript_id');

        foreach ($oldMappings as $manuscriptId => $ms) {
            if (!$pageMappings->has($manuscriptId)) {
                ManuscriptMapping::where('manuscript_id', "=", $manuscriptId)->delete();
            }
        }

        foreach ($pageMappings as $manuscriptId => $ms) {
            $verseMappings = $mapper->makeMappings($ms, $manuscriptId);

            ManuscriptMapping::where('manuscript_id', "=", $manuscriptId)->delete();

            ManuscriptMapping::insert($verseMappings);

        }


    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $suraToMaxVerse = Koranstelle::getVerseCounts()->mapWithKeys(fn($s) => [$s->sura => $s->max_verse]);
        $mapper = new ManuscriptMapper($suraToMaxVerse);
        $manuscriptId = $this->argument('manuscript_id');

        if (isset($manuscriptId)) {
            Log::info("Updating manuscript mappings for manuscript {$manuscriptId}");
            $this->updateSingleManuscript($mapper, $manuscriptId);
        } else {
            Log::info("Updating all manuscript mappings.");
            $this->updateAllManuscripts($mapper);
        }
    }
}
