<?php

namespace App\Console\Commands;

use App\Models\Manuskripte\Manuskript;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportHandschriftenLiteratur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manuskript:exportliteratur';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command iterates over all
    manuscripts and writes the literatur-field to a file';

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
        // Get all manuscripts
        $manuscripts = Manuskript::all();

        // Set output filename
        $outFile = "handschriften_literatur_" . Carbon::now("Europe/Berlin")->now()->format("Ymd_his") . ".txt";

        $outString = "";

        // Iterate over all manuscripts
        foreach($manuscripts as $manuscript)
        {

            if (!empty($manuscript->Literatur))
            {
                $title = $manuscript->ID . ": " . $manuscript->Kodextitel . "\n\n";

                $outString .= $title . $manuscript->Literatur . "\n\n";

                $outString .= "############################################\n\n";
            }


        }

        Storage::put($outFile, $outString);

        echo "Done\n";
    }
}
