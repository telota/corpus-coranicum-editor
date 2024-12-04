<?php

namespace App\Console\Commands;

use App\Models\Koran;
use App\Models\Lesarten\Leseart;
use App\Models\Lesarten\Leser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Koranstelle;
use Illuminate\Console\Command;
use App\Library\Matrix;
use Illuminate\Support\Facades\Storage;

class CompareLesartenCanonicBySuraVerse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compare:lesarten:canon:suraverse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $outputDir = "similarities/suraverse/";

        /*
         * Sigles of canonic readers
         */
        $leserKanonischSigles = array('0100', '0200', '0300', '0400', '0500', '0600', '0700');
        $leserKanonischUeberliefererSigles = array(
            '0101', '0102',
            '0201', '0202',
            '0301', '0302',
            '0401', '0402',
            '0501', '0502',
            '0601', '0602',
            '0701', '0703');

        // Result see statement below
        // $maxVariants = getMaxVariants();
        $maxVariants = 18;



        // Populate Leser Id array (id => sigle)
        $leserKanonischIds = Leser::whereIn("sigle", $leserKanonischSigles)
            ->get()
            ->pluck("id", "sigle")
            ->toArray();

        $leserKanonischUeberliefererIds = Leser::whereIn("sigle", $leserKanonischUeberliefererSigles)
            ->get()
            ->pluck("sigle", "id")
            ->toArray();

        $versstelle = Koranstelle::where("sure", 1)->where("vers", 1)->first();

        while ($versstelle->getNextVerse())
        {

            $sure = $versstelle->sure;
            $vers = $versstelle->vers;

            $output = $outputDir . $sure . "/leser_similarities_canon_sure_" . str_pad($sure, 3, 0, STR_PAD_LEFT) .
                "_vers_" . str_pad($vers, 3, 0, STR_PAD_LEFT) . "_" . Carbon::now("Europe/Berlin")->now()->format("Ymd_his") . ".csv";

            echo $output . "\n";

            $koranstellen = Koranstelle::where("sure", $sure)->where("vers", $vers)->get();

            $i = 0;

            // Count the words in the quran
            $numWords = Koranstelle::where("vers", "<>", 0)
                ->where("wort", "<>", 0)
                ->where("sure", $sure)
                ->where("vers", $vers)
                ->count();

            $lesartenMatrix = new Matrix($numWords, $maxVariants);

            $leserMatrixArray = array();

            // Instantiating Leser
            foreach(Leser::whereIn("sigle", $leserKanonischUeberliefererSigles)->get() as $leser)
            {
                $leserMatrixArray[$leser->id] = new Matrix($numWords, $maxVariants);
            }


            foreach($koranstellen as $koranstelle)
            {

                // Variants for of a word
                $varianten = array();

                // Add Druckausgabe version to varianten
                array_push($varianten, trim($koranstelle->transkription));

                // Get all lesearten for the current Koranstelle
                $lesearten = Leseart::where("sure", "=", $koranstelle->sure)
                    ->where("vers", "=", $koranstelle->vers)
                    ->get();


                // Iterate over the Lesarten
                foreach ($lesearten as $leseart) {

                    if ($koranstelle->wort > sizeof($leseart)) {
                        continue;
                    }

                    // Get the variant reading
                    $variantenWort = trim($leseart->variantenWort($koranstelle->wort)->variante);

                    // Add the variant reading to the array
                    if (!(in_array($variantenWort, $varianten)))
                    {
                        array_push($varianten, $variantenWort);
                    }

                }

                sort($varianten);

                if (in_array("", $varianten))
                {
                    $emptyPos = array_search("", $varianten);
                    unset($varianten[$emptyPos]);
                    array_push($varianten, "");
                }

                // re-index array
                $varianten = array_values($varianten);

                // Populate the main matrix
                foreach ($varianten as $index => $variante)
                {
                    $lesartenMatrix->set($i, $index, $variante);
                }

                // Iterate over the readers again
                foreach($lesearten as $leseart)
                {

                    if ($koranstelle->wort > sizeof($leseart)) {
                        continue;
                    }

                    // Get the variant reading
                    $variantenWort = trim($leseart->variantenWort($koranstelle->wort)->variante);

                    // Determine the position of the variant in the main matrix
                    $colPosition = array_search($variantenWort, $varianten);


                    foreach($leseart->leser as $leser)
                    {

                        // Get the leser id
                        $leserId = $leser->id;

                        if (array_key_exists($leserId, $leserMatrixArray))
                        {
                            $leserMatrixArray[$leserId]->set($i, $colPosition, 1);
                        }

                        else if (array_key_exists($leserId, $leserKanonischIds))
                        {

                            $kanonischerLeserSigle = $leserKanonischIds[$leserId];
                            $kanonischerUeberliefererId1 = $leserKanonischUeberliefererIds[substr_replace($kanonischerLeserSigle, "1", -1)];
                            $kanonischerUeberliefererId2 = $leserKanonischUeberliefererIds[substr_replace($kanonischerLeserSigle, "2", -1)];



                            $leserMatrixArray[$kanonischerUeberliefererId1]->set($i, $colPosition, 1);
                            $leserMatrixArray[$kanonischerUeberliefererId2]->set($i, $colPosition, 1);

                        }

                    }

                }



                // Get the variant reading
                $standardWort = trim($koranstelle->transkription);

                // Determine the position of the variant in the main matrix
                $standardColPosition = array_search($standardWort, $varianten);
                foreach($leserMatrixArray as $leser => $matrix)
                {
                    if ($matrix->columnIsEmpty($i))
                    {
                        $matrix->set($i, $standardColPosition, 1);
                    }
                }

                $i++;



            }


            $leserString = "\t";
            foreach($leserMatrixArray as $leserIdMain => $leserMatrixMain)
            {

                $leserName = Leser::find($leserIdMain)->anzeigename . " (" . $leserIdMain . ")";
                $leserString .= $leserName . "\t";
            }

            Storage::put($output, $leserString);

            $similarityMatrix = array();

            foreach($leserMatrixArray as $leserIdMain => $leserMatrixMain)
            {

                $similarityMatrix[$leserIdMain] = array();
                $leserName = Leser::find($leserIdMain)->anzeigename . " (" . $leserIdMain . ")";
                $rowString = $leserName . "\t";

                foreach($leserMatrixArray as $leserIdChild => $leserMatrixChild)
                {

                    //echo "Computing " . $leserIdMain . " and " . $leserIdChild . " - " ;

                    $similarity = null;

                    if (array_key_exists($leserIdChild, $leserMatrixArray)) {
                        if (array_key_exists($leserIdMain, $leserMatrixArray[$leserIdChild])) {
                            $similarity = $leserMatrixArray[$leserIdChild][$leserIdMain];
                        }
                    }

                    if ($similarity == null)
                    {
                        $similarity = $leserMatrixMain->euclidianSim($leserMatrixChild);
                    }

                    $similarityMatrix[$leserIdMain][$leserIdChild] = $similarity;

                    $rowString .= $similarity . "\t";

                    //echo  "Result: " . $similarity . "\n";

                }

                Storage::append($output, $rowString);


            }

            $versstelle = $versstelle->getNextVerse();

        }




    }





    private function getMaxVariants()
    {
        /*
        $maxVariants = DB::select("
SELECT MAX(numvariante) as maxvarianten
FROM(
  SELECT sure, vers, wort, COUNT(DISTINCT(variante)) as numvariante
  FROM(
        (SELECT sure, vers, wort, variante
         FROM lc_leseart AS l, lc_variante AS v
         WHERE l.id = leseart)

        UNION

        (SELECT sure, vers, wort, transkription as variante
         FROM lc_kkoran AS k)
      ) AS variants

  GROUP BY sure, vers, wort
) AS numvariants")[0]->maxvarianten;

        return $maxVariants;
        */


    }
}
