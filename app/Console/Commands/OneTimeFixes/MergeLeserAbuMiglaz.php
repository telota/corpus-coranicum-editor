<?php

namespace App\Console\Commands\OneTimeFixes;

use App\Models\Lesarten\Leser;
use Illuminate\Console\Command;

class MergeLeserAbuMiglaz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lesarten:merge:abumiglaz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge Leser with ID 35 to 303';

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

        $leserToMerge = Leser::find(35);
        $targetLeser = Leser::find(303);

        $targetLeser->kommentar = $targetLeser->kommentar . "\n" . $leserToMerge->kommentar;
        $targetLeser->save();

        foreach($leserToMerge->mappings as $mapping)
        {

            $mapping->leser = $targetLeser->id;
            $mapping->save();

        }

        $leserToMerge->delete();

    }
}
