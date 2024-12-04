<?php

namespace App\Console\Commands\OneTimeFixes;

use App\Models\Konkordanz;
use Illuminate\Console\Command;

class AddCoordinatesToQortbl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konkordanz:add-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add CC coodinates to qortbl';

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

        foreach(Konkordanz::all() as $konkordanzStelle)
        {

            // Reverse string to extract sura and verse
            $reversedCoordinate = strrev($konkordanzStelle->suraverse);

            $vers = intval(strrev(substr($reversedCoordinate, 0, 3)));
            $sure = intval(strrev(substr($reversedCoordinate, 3)));

            $konkordanzStelle->sure_cc = $sure;
            $konkordanzStelle->vers_cc = $vers;
            $konkordanzStelle->wort_cc = $konkordanzStelle->word_num;

            $konkordanzStelle->save();

        }

    }
}
