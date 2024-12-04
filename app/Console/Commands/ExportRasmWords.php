<?php

namespace App\Console\Commands;

use App\Models\Koran;
use App\Models\Koranstelle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportRasmWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:rasm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all Quran words with their rasm';

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

        $words = "Sure\tVers\tWort\tTranskription\tArab\tRasm\n";
        foreach (Koranstelle::all() as $koranstelle) {#
            $words .= "{$koranstelle->sure}\t{$koranstelle->vers}\t{$koranstelle->wort}\t" .
                      "{$koranstelle->transkription}\t{$koranstelle->arab}\t{$koranstelle->rasm}\n";
        }

        Storage::put("ccdb_rasm.tsv", $words);

    }
}
