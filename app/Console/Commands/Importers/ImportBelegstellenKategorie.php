<?php

namespace App\Console\Commands\Importers;

use App\Console\Commands\Helpers\CsvReader;
use App\Models\Umwelttexte\BelegstellenKategorie;
use App\Models\Umwelttexte\Belegstelle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportBelegstellenKategorie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:belegstellenKategorie';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import old data from belegstellenKategorie to new migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    //const DIR_REPLACE = 'P:\OriginalScan\AndereScans\Gotha_Koranfragmente\ ';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $belegstellen = Belegstelle::all();

        foreach ($belegstellen as $belegstelle) {
            $kategorie = BelegstellenKategorie::where([
                "classification" => $belegstelle->kategorie
            ])->first();

            if (!$kategorie) {
                continue;
            }
            $belegstelle->kategorie = $kategorie->id;
            $belegstelle->save();
        }
    }

    private function oldMethod()
    {
        $belegstellen = Belegstelle::all();

        // Read TSV input
        $mainCsv = CsvReader::readCsv(Storage::get("cc_belegstellen.tsv"));
        // Iterate over all entries
        foreach ($mainCsv as $entry) {
            $belegstelle = new BelegstellenKategorie();
            //check for classification
            $arr1 = str_split($entry["id"]);

            if (count($arr1)>1) {
                $belegstelle->supercategory = 1;
            } else {
                $belegstelle->supercategory = 0;

            }
            $belegstelle->classification = $entry["id"];
            $belegstelle->name = $entry["name"];
            $belegstelle->save();
        }

        $notSuperCategories = BelegstellenKategorie::where("supercategory", 1)->get();

        //dd($notSuperCategories);
        foreach ($notSuperCategories as $category) {
            $arr1 = str_split($category["classification"]);

            if (count($arr1) > 1) {
                $category->supercategory = BelegstellenKategorie::where("classification", $arr1[0])->first()->id;
                $category->save();
            }
        }


        //get all umwelttext-kategorien and change the reference to the "belegstellenkategorie"
        $belegstellen = Belegstelle::all();

        foreach ($belegstellen as $stelle) {
            if (preg_match('/[a-zA-Z]+/', $stelle->kategorie) &&
                BelegstellenKategorie::where("classification", $stelle->kategorie)->first() != null) {
                $stelle->kategorie = BelegstellenKategorie::where("classification", $stelle->kategorie)->first()->id;
                $stelle->save();
            }
        }
    }
}
