<?php

namespace App\Console\Commands\Importers;


use Illuminate\Console\Command;
use App\Models\KoranUebersetzung;
use Illuminate\Support\Facades\Storage;

//use Illuminate\Support\Facades\Storage;
//use Illuminate\Contracts\Bus\SelfHandling;

class ImportTanzilTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tanzil_translations {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import translations from tanzil';
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
     */
    public function handle()
    {
        // Read txt file
        //$file = File::get(storage_path('app/tanzilTranslations/en.pickthall.txt'));
        $file = Storage::get($this->argument('file'));

        //  Save translation per line in an array
        $arrayofLines = explode ( "\n", $file );

        // Get sprache field from text
        $spracheArray = preg_grep("/^\#  ID\: .*$/", $arrayofLines);

        foreach ($spracheArray as $key => $value) {
            $sprache = substr($value, 7);
        }

        $spracheField = preg_replace('/[.]/', '_', $sprache);

        // Iterate over all lines of translation and insert into db
        $translation = preg_grep("/^(\d+)?\|(\d+)?\|.*$/", $arrayofLines);



        foreach ($translation as $line) {
            $arrayOfVers = explode('|', $line);
                $sure = intval($arrayOfVers[0]);
                $vers = intval($arrayOfVers[1]);
                $sureVers = str_pad($sure, 3, 0, STR_PAD_LEFT) . ":" .
                    str_pad($vers, 3, 0, STR_PAD_LEFT);
                KoranUebersetzung::firstOrCreate([
                    'sprache' => $spracheField,
                    'text' => $arrayOfVers[2],
                    'sure_vers' => $sureVers,
                    'sure' => $sure,
                    'vers' => $vers
                ]);
        }


    }
}
