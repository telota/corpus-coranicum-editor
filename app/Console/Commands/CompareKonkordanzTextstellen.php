<?php

namespace App\Console\Commands;

use App\Models\Konkordanz;
use App\Models\Sure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CompareKonkordanzTextstellen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compare:konkordanz_textstellen';

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

        $outString = "Sure:Vers\tWorte CC\tWorte RTK\n";

        for ($sure = 1; $sure < 115; $sure++)
        {

            $maxVers = Sure::getMaxVers($sure);

            for ($vers = 1; $vers <= $maxVers; $vers++)
            {

                $maxWortCC = Sure::getMaxWort($sure, $vers);

                $maxWortRTK = Konkordanz::where("suraverse", $sure . str_pad($vers, 3, 0, STR_PAD_LEFT))
                    ->max("word_num");


                if ($maxWortCC != $maxWortRTK)
                {
                    $outString .= str_pad($sure, 3, 0, STR_PAD_LEFT) . ":" . str_pad($vers, 3, 0, STR_PAD_LEFT) . "\t" . $maxWortCC . "\t" . $maxWortRTK . "\n";
                }



            }

        }

        Storage::put("RTK_CC_differences.csv", $outString);

    }
}
