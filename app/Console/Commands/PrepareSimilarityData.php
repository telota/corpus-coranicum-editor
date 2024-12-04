<?php

namespace App\Console\Commands;

use App\Models\Koranstelle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PrepareSimilarityData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compare:lesarten:prepare';

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
        /*
        for($sura = 1; $sura <= 114; $sura++)
        {
            $this->prepareSuraVerseData($sura);
        }
        */

        $this->prepareSuraData();

    }

    private $readerPairs = array(
        1 => "Qālūn & Warš",
        2 => "al-Bazzī & Qunbul",
        3 => "ad-Dūrī & as-Sūsī",
        4 => "Ibn Ḏakwān & Hišām",
        5 => "Šuʿba & Ḥafṣ",
        6 => "Ḫalaf & Ḫallād",
        7 => "al-Laiṯ & Nuṣair ar-Razī"
    );

    private function prepareSuraData()
    {

        $similarities = array();

        foreach ($this->readerPairs as $index => $pair)
        {
            $similarities[$index] = array();
        }

        $inputDir = "similarities/sura/";

        $outputDir = "similarities/digest/table/sura/";
        $outputName = "leser_canon_digest_table_all_suras_" . Carbon::now("Europe/Berlin")->now()->format("Ymd_his") . ".csv";

        $inputFiles = Storage::files($inputDir);

        natsort($inputFiles);

        foreach($inputFiles as $suraIndex => $inputFile)
        {

            $file = Storage::get($inputFile);

            $sura = $suraIndex + 1;


            $values = $this->readCsv($file);

            // Set reader pair values
            $similarities[1][$sura] = $values[0]["Warš (54)"];
            $similarities[2][$sura] = $values[2]["Qunbul (81)"];
            $similarities[3][$sura] = $values[4]["as-Sūsī (102)"];
            $similarities[4][$sura] = $values[6]["Hišām (124)"];
            $similarities[5][$sura] = $values[8]["Ḥafṣ (129)"];
            $similarities[6][$sura] = $values[10]["Ḫallād (149)"];
            $similarities[7][$sura] = $values[12]["Nuṣair ar-Razī (174)"];

        }

        $outputStringHead = "\t";

        $suras = array_keys($similarities[1]);
        sort($suras);



        foreach($suras as $sura)
        {
            $outputStringHead .= $sura . "\t";
        }

        Storage::put($outputDir . $outputName, $outputStringHead);

        foreach($this->readerPairs as $index => $pair)
        {

            $pairString = $pair . "\t";

            $pairSimilarities = $similarities[$index];

            foreach($pairSimilarities as $sura => $similarity)
            {
                $pairString .= $similarity . "\t";
            }

            Storage::append($outputDir . $outputName, $pairString);


        }



    }

    private function prepareSuraVerseData($sura)
    {

        $similarities = array();

        foreach ($this->readerPairs as $index => $pair)
        {
            $similarities[$index] = array();
        }


        $inputDir = "similarities/suraverse/" . $sura . "/";

        $outputDir = "similarities/digest/table/suraverse/";
        $outputName = "leser_canon_digest_table_suraverse_" . $sura . "_" . Carbon::now("Europe/Berlin")->now()->format("Ymd_his") . ".csv";



        $inputFiles = Storage::files($inputDir);

        natsort($inputFiles);

        foreach($inputFiles as $verseIndex => $inputFile)
        {

            $file = Storage::get($inputFile);

            $verse = $verseIndex + 1;


            $values = $this->readCsv($file);

            // Set reader pair values
            $similarities[1][$verse] = $values[0]["Warš (54)"];
            $similarities[2][$verse] = $values[2]["Qunbul (81)"];
            $similarities[3][$verse] = $values[4]["as-Sūsī (102)"];
            $similarities[4][$verse] = $values[6]["Hišām (124)"];
            $similarities[5][$verse] = $values[8]["Ḥafṣ (129)"];
            $similarities[6][$verse] = $values[10]["Ḫallād (149)"];
            $similarities[7][$verse] = $values[12]["Nuṣair ar-Razī (174)"];


        }

        $outputStringHead = "\t";

        $verses = array_keys($similarities[1]);
        sort($verses);



        foreach($verses as $verse)
        {
            $outputStringHead .= $verse . "\t";
        }

        Storage::put($outputDir . $outputName, $outputStringHead);

        foreach($this->readerPairs as $index => $pair)
        {

            $pairString = $pair . "\t";

            $pairSimilarities = $similarities[$index];

            foreach($pairSimilarities as $verse => $similarity)
            {
                $pairString .= $similarity . "\t";
            }

            Storage::append($outputDir . $outputName, $pairString);


        }





    }

    private function readCsv($file)
    {


        $lines = explode("\n", $file);
        $head = str_getcsv(array_shift($lines) , "\t");

        $array = array();
        foreach ($lines as $line) {
            $array[] = array_combine($head, str_getcsv($line, "\t"));
        }

        return $array;
    }
}
