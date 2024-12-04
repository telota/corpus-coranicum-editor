<?php

namespace App\Console\Commands;

use App\Models\Manuskripte\Manuskript;
use App\Models\Lesarten\Quelle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportQuellenLiteratur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quellen:exportliteratur';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command iterates over all
    reading variants sources and writes the literatur-field to a file';

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
        $quellen = Quelle::all();

        // Set output filename
        $outFile = "quellen_literatur_" . Carbon::now("Europe/Berlin")->now()->format("Ymd_his") . ".txt";

        $outString = "";

        // Iterate over all manuscripts
        foreach($quellen as $quelle)
        {

            if (!empty($quelle->referenz))
            {
                $title = $quelle->id . ": " . $quelle->anzeigetitel . "(" . $quelle->abkuerzung . ")" . "\n\n";

                $outString .= $title . $quelle->referenz . "\n\n";

                $outString .= "############################################\n\n";
            }


        }

        Storage::put($outFile, $outString);

        echo "Done\n";
    }
}
