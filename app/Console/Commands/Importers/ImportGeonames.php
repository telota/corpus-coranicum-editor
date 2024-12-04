<?php

namespace App\Console\Commands\Importers;


use App\ImageDetail;
use App\Models\Manuskripte\Aufbewahrungsort;
use App\Manuskripte\Manuskriptseite;
use App\Manuskripte\ManuskriptseitenBild;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Console\Commands\Helpers\CsvReader;

//use Illuminate\Support\Facades\Storage;
//use Illuminate\Contracts\Bus\SelfHandling;

class ImportGeonames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:geonames {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import geonames from csv files';
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
     * Execute the command.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        // Read txt file
        $file = Storage::get($this->argument('file'));
        $array = CsvReader::readCsv($file, $delimeter = ",");

        foreach ($array as $ort) {
            $aufbewahrungsort = Aufbewahrungsort::find((int) $ort["AufbewahrungsortID"]);
            $aufbewahrungsort->longitude = (double) $ort["longitude"];
            $aufbewahrungsort->latitude = (double) $ort["latitude"];
            $aufbewahrungsort->geonames = $ort["geonames"];
            $aufbewahrungsort->save();
        }
    }
}
