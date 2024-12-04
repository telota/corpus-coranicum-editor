<?php

namespace App\Console\Commands;

use App\Console\Commands\Helpers\CsvReader;
use App\Models\Umwelttexte\Belegstelle;
use App\Models\Umwelttexte\BelegstellenKategorie;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * Class CreateBelegstellenKategorien
 * @package App\Console\Commands
 */
class CreateBelegstellenKategorien extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'umwelttexte:create-kategorien';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create categories for belegstellen';

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
     */
    public function handle()
    {
        try {
            $this->importCategories();
        } catch (FileNotFoundException $e) {
            throw new $e;
        }

        try {
            $this->mapCategoriesToBelegstellen();
        } catch (FileNotFoundException $e) {
            throw new $e;
        }
    }


    /**
     * Create a super category for BelegstellenKategorie
     * @param $category
     */
    private function createSuperCategory($category)
    {
        $superCategory = BelegstellenKategorie::firstOrCreate([
            "id" => $category["super"]
        ]);

        $superCategory->name = $category["kategorie"];
        $superCategory->save();
    }

    /**
     * Create a subcategory for BelegstellenKategorie
     * @param $category
     */
    private function createSubCategory($category)
    {
        $subCategory = BelegstellenKategorie::firstOrCreate([
            "id" => "{$category["super"]}{$category["sub"]}"
        ]);

        $subCategory->name = $category["werk"];
        $subCategory->save();
    }

    /**
     * Import Categories
     */
    private function importCategories()
    {
        // Read category file
        try {
            $categories = CsvReader::readCsv(\Storage::get("tuk_kategorien.csv"));

            // Iterate over categories
            foreach ($categories as $category) {
                // Create super category
                if ($category["kategorie"] && !$category["werk"]) {
                    $this->createSuperCategory($category);
                    continue;
                }

                // Create subcategory
                $this->createSubCategory($category);
            }
        } catch (FileNotFoundException $e) {
            echo $e->getMessage();
        }
    }

    private function mapCategoriesToBelegstellen()
    {
        try {
            $mappings = CsvReader::readCsv(\Storage::get("tuk_kategorien_zuordnung.csv"));

            foreach ($mappings as $mapping) {
                $belegstelle = Belegstelle::find($mapping["id"]);
                $belegstelle->kategorie = "${mapping["super"]}${mapping["sub"]}";
                $belegstelle->save();
            }
        } catch (FileNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}
