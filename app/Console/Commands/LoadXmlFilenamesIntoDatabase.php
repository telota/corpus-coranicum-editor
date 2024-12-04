<?php

namespace App\Console\Commands;

use App\Models\Kommentar;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuskripte\Manuskript;
use App\Models\Umwelttexte\Belegstelle;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LoadXmlFilenamesIntoDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-xml-filenames-into-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function writeIntertextCommentaryRelationsToDatabase(){
        $user = User::where('name','DATA_MIGRATION')->first();
        Auth::login($user);
        $commentaries = Kommentar::where('sure','>',0)->get();
        foreach ($commentaries as $c){
            if (!$c->commentary_file){
                continue;
            }
            $intertexts = [];
            $file = Storage::disk('xml_files')->path('Kommentar/' . $c->commentary_file);
            $xml = simplexml_load_file($file);
            $refs = $xml->xpath("//ref") ?? [];
            foreach($refs as $ref){
                $target = $ref['target'];
                if( $target)
                {
                    $it_number = [];
                    $matched = preg_match("/#TUK(\d+)?/", $target, $it_number);

                    if($matched && isset($it_number[1])){
                        $intertexts[] = (int)$it_number[1];
                    }
                }
            }

            $existing_intertexts = [];
            foreach($intertexts as $i){
                $b = Belegstelle::find($i);
                if(!isset($b)){
                    Log::warning("No Intertext found with ID $i");
                    continue;
                }
                $existing_intertexts[] =$i;
            }

            $c->intertextsMentioned()->sync($existing_intertexts);
        }



    }


    private function getSura($file): ?int
    {
        $path = Storage::disk('xml_files')->path($file);
        $xml = simplexml_load_file($path);
        $maybeId = $xml->xpath("//sure/@id | //Sure/@id");
        if (sizeof($maybeId) == 0) {
            $this->error("No sure id detected for $file");
            return null;
        }
        if (sizeof($maybeId) > 1) {
            $this->error("More than one sure id detected for $file");
            return null;
        }

        $webtauglich = $xml->xpath("//Sure[@webtauglich='true'] | //sure[@webtauglich='true']");
        if (sizeof($webtauglich) < 1) {
            $this->error("Webtauglich true not found for $file.");
            return null;
        }

        return (int)$maybeId[0];

    }

    private function getCommentary()
    {

        $files = Storage::disk('xml_files')->files('Kommentar');

        foreach ($files as $file) {
            $filename = basename($file);


            if (!Str::endsWith($filename, ".xml")
                || !Str::startsWith($filename, 'Kommentar')) {
                continue;
            }

            if ($filename == 'KommentarOverlay-Mekka_II.xml') {
                $sure = 0;
            } else {
                $sure = $this->getSura($file);
            }

            if (!isset($sure)) {
                continue;
            }


            $result = Kommentar::firstOrCreate(["sure" => $sure]);
            $this->info("Saving $filename");
            $result->commentary_file = $filename;
            $result->save();

        }
    }

    private function getTextStructure()
    {

        $files = Storage::disk('xml_files')->files('Textstruktur');

        foreach ($files as $file) {
            $filename = basename($file);


            if (!Str::endsWith($filename, ".xml")
                || !Str::startsWith($filename, 'Sure')) {
                continue;
            }

            $sure = $this->getSura($file);

            if (!isset($sure)) {
                continue;
            }

            $result = Kommentar::firstOrCreate(["sure" => $sure]);

            $this->info("Saving $filename");
            $result->text_structure_file = $filename;
            $result->save();

        }
    }

    public function getTransliterations()
    {

        $files = Storage::disk('xml_files')->files('Manuskript');

        foreach ($files as $file) {
            $this->info("Working on $file");

            if (!Str::endsWith($file, ".xml")) {
                continue;
            }

            /* Not sure why we exclude this file, but it was in the
            code for FetchExistData */
            if (str_contains($file, "415-Paris_7192_SB.xml")) {
                continue;
            }

            $path = Storage::disk('xml_files')->path($file);
            $xml = simplexml_load_file($path);

            $manuscriptId = intval($xml->xpath("//doc/@ms")[0]->ms);

            $manuscript = ManuscriptNew::find($manuscriptId);
            if ($manuscript) {
                $this->info("Setting transliteration file $file for manuscript $manuscriptId");
                $manuscript->transliteration_file = basename($file);
                $manuscript->save();
            } else {
                $this->warn("No Manuscript found for $file");
            }


        }
    }

    /**
     * Execute the console command.
     */
    public
    function handle()
    {
        $this->getCommentary();
        $this->writeIntertextCommentaryRelationsToDatabase();
        $this->getTextStructure();
        $this->getTransliterations();
    }

}
