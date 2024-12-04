<?php

namespace App\Console\Commands;

use App\Models\Konkordanz;
use App\Models\Koranstelle;
use Illuminate\Console\Command;

class InsertWordsIntoKonkordanz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konkordanz:cc_words';

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

        $koranWords = Koranstelle::all();

        $i = 0;

        foreach($koranWords as $word)
        {

            if ($i % 1000 == 0) {
                echo "Processed $i" . " of " . $koranWords->count() . "\n";
            }

            $suraverse = $word->sure . str_pad($word->vers, 3, 0, STR_PAD_LEFT);

            $konkordanzWords = Konkordanz::where("suraverse", $suraverse)
                ->where("word_num", $word->wort)
                ->get();

            foreach ($konkordanzWords as $konkordanzWord)
            {

                $konkordanzWord->word_cc = $word->transkription;
                $konkordanzWord->save();

            }

            $i++;

        }

        echo "Done\n";

    }
}
