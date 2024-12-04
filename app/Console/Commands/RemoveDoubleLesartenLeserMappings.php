<?php

namespace App\Console\Commands;

use App\Models\Lesarten\LeseartLeser;
use Illuminate\Console\Command;

class RemoveDoubleLesartenLeserMappings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lesarten:remove-double-mappings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove double entries of leser-lesarten-mappings';

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

        $multiMappings = collect([]);

        foreach(LeseartLeser::all() as $mapping)
        {

            $count = LeseartLeser::where([
                "leser" => $mapping->leser,
                "leseart" => $mapping->leseart
            ])->count();

            if ($count > 1)
            {

                $key = $mapping->leser . ":" . $mapping->leseart;

                if(!($multiMappings->has($key)))
                {
                    $multiMappings[$key] = collect([]);
                }

                $multiMappings[$key]->push($mapping);

            }

        }

        echo $multiMappings->count() . "\n";

        foreach($multiMappings as $multiMapping)
        {

            foreach($multiMapping->slice(1) as $deleteMapping)
            {

                $deleteMapping->delete();

            }

        }


    }
}
