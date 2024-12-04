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

class CompareLesarten extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compare:lesarten';

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

        $output = "leser_similarities_" .Carbon::now("Europe/Berlin")->now()->format("Ymd_his") . ".csv";

        // Count the words in the quran
        $numWords = Koranstelle::where("vers", "<>", 0)
            ->where("wort", "<>", 0)
            ->count();


        // Result see statement below
        // $maxVariants = getMaxVariants();
        $maxVariants = 18;

        $lesartenMatrix = new Matrix($numWords, $maxVariants);

        $leserMatrixArray = array();


        // Instantiating Leser


        foreach(Leser::all() as $leser)
        {
            $leserMatrixArray[$leser->id] = new Matrix($numWords, $maxVariants);
        }


        $i = 0;

        foreach(Koranstelle::getAllWordsExceptHeaders() as $koranstelle)
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

                // Get the leser id
                // Note: I do not understand this code. One Leseart can have multiple Leser.
                $leserId = $leseart->leser->id;

                $leserMatrixArray[$leserId]->set($i, $colPosition, 1);

            }

            if ($i % 250 == 0) {

                echo "Processing " . $i . " of " . $numWords . "\n";

            }

            // Increase row counter
            $i++;

        }


        $leserString = "\t";
        foreach($leserMatrixArray as $leserIdMain => $leserMatrixMain)
        {
            $leserString .= $leserIdMain . "\t";
        }

        Storage::put($output, $leserString);

        $similarityMatrix = array();

        foreach($leserMatrixArray as $leserIdMain => $leserMatrixMain)
        {


            $similarityMatrix[$leserIdMain] = array();
            $rowString = $leserIdMain . "\t";

            foreach($leserMatrixArray as $leserIdChild => $leserMatrixChild)
            {

                echo "Computing " . $leserIdMain . " and " . $leserIdChild . " - " ;

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

                echo  "Result: " . $similarity . "\n";

            }

            Storage::append($output, $rowString);



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
