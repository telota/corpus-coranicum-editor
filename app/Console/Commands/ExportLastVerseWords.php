<?php

namespace App\Console\Commands;

use App\Models\Koranstelle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportLastVerseWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:last-verse-words';

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
        $verses = Koranstelle::getAllVerses();

        $exportString = "sure\tvers\twort\tarabisch\ttranskription\n";

        // Iterate over all verses
        foreach($verses as $verse)
        {

            if ($verse->sure == 0 || $verse->vers == 0)
            {
                continue;
            }

            $lastWord = Koranstelle::getVers($verse->sure, $verse->vers)->last();

            $line =
                $lastWord->sure . "\t" .
                $lastWord->vers . "\t" .
                $lastWord->wort . "\t" .
                $lastWord->arab . "\t" .
                $lastWord->transkription . "\n";

            $exportString .= $line;

        }

        Storage::put("Last-Verse-Words.tsv", $exportString);
    }
}
