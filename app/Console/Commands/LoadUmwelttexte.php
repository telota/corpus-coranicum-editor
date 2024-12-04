<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Umwelttexte\Belegstelle;
use Illuminate\Support\Facades\Storage;

class LoadUmwelttexte extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'umwelttext:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Umwelttexte list for summernote selects';

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
        $itemArray = Belegstelle::all('ID','Titel')->toArray();

        $selectForm = view("includes.umwelttexte.select", [
            "label" => "Umwelttexte",
            "items" => $itemArray
        ])->render();

        Storage::put("umwelttext/umwelttext.html", $selectForm);
    }
}
