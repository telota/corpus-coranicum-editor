<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripHtmlTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:strip-html-tags {table} {column}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');

        $entries = DB::table($table)->get();

        $column = $this->argument('column');

        foreach ($entries as $entry) {
            if ($entry->$column !== strip_tags($entry->$column)) {
                Log::info("Stripping tags from {$entry->$column}.");
                DB::table($table)
                    ->where($column, $entry->$column)
                    ->update([
                        $column => trim(strip_tags($entry->$column))
                    ]);
            }

        }
    }
}
