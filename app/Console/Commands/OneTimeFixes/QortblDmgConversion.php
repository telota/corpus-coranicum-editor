<?php

namespace App\Console\Commands\OneTimeFixes;

use App\Models\Konkordanz;
use Illuminate\Console\Command;

class QortblDmgConversion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konkordanz:dmg-conversion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transform the base field to dmg';

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

            $konkordanzStelle->base_cc = Konkordanz::rtkToDmg($konkordanzStelle->base);
            $konkordanzStelle->root_cc = Konkordanz::rtkToDmg($konkordanzStelle->root);
            $konkordanzStelle->save();

        }

    }
}
