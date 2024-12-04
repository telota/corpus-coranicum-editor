<?php

namespace App\Console\Commands;

use App\Models\Umwelttexte\Belegstelle;
use Illuminate\Console\Command;

class TransformUmwelttexteLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transform:umwelttexte_url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command transforms links in the Anmerkungen-field.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all Belegstellen
        $belegstellen = Belegstelle::all();

        foreach ($belegstellen as $belegstelle)
        {

            $anmerkung = $belegstelle->Anmerkungen;

            $webtauglich = false;

            if ($belegstelle->webtauglich == "ja")
            {
                $webtauglich = true;
            }

            if ($webtauglich)
            {
                $anmerkung = $this->transformPublic($anmerkung);
            }

            else {
                $anmerkung = $this->transformEdit($anmerkung);
            }

            /*
             * $belegstelle->Anmerkungen = $anmerkung;
             * $belegstelle->save();
             *
             */

        }
    }

    /**
     * Replaces all telotadev/koran URLs with links to Corpus Coranicum
     * @param $anmerkung
     */
    private function transformPublic($anmerkung)
    {

        preg_match_all('/<a href="(.*?)"/s', $anmerkung, $matchesAll);

        foreach ($matchesAll as $matches)
        {

            foreach($matches as $match)
            {
                if (str_contains($match, "umwelttxt") && starts_with($match, "http"))
                {

                    // Now only relevant matches appear
                    $belegstellenId = explode("ID=", $match)[1];

                    $reference = Belegstelle::find($belegstellenId);

                    if (count($reference->koranstellen) <= 0)
                    {
                        echo "Texstellen fehlen -- TUK " . $reference->ID . ": " . $reference->Titel . " -- " . $reference->Bearbeiter . "\n";
                    }

                    if ($reference->webtauglich == "nein")
                    {
                        echo "Nicht webtauglich -- TUK " . $reference->ID . ": " . $reference->Titel . " -- " . $reference->Bearbeiter . "\n";
                    }

                    /*
                    $koranstelle = Belegstelle::find($belegstellenId)->koranstellen[0];

                    // Form new url
                    $ccdbUrl = "https://www.corpuscoranicum.de/kontexte/index/sure/" .
                        $koranstelle->sure_start . "/vers/" .
                        $koranstelle->vers_start . "/intertext/" .
                        $belegstellenId;

                    $anmerkung = str_replace($match, $ccdbUrl, $anmerkung);
                    */
                }
            }


        }

        //echo $anmerkung . "\n\n---\n\n";




    }

    /**
     * Replaces all telotadev/koran URLs with links to CCedit.
     * @param $anmerkung
     */
    private function transformEdit($anmerkung)
    {
        $count = preg_match("/(http|https).*umwelttxt.*\"/", $anmerkung, $matches);

        if ($count > 0)
        {

        }


    }
}
