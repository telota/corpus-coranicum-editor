<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ZoteroBibliography;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DownloadZotero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zotero:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'loads zotero data from api and stores it in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    function getZoteroData($zotero_url, $maxAttempts = 5)
    {
        $attempt = 1; // current attempt number
        do {
            if ($attempt > 1) {
                Log::info('zotero:download: ' . $attempt . ' attempt');
            }
            $zotero_json = @file_get_contents($zotero_url);
            $result = json_decode($zotero_json, true);
            if (is_array($result)) {
                return $result;
            }
            sleep(10);
            $attempt++;
        } while ($attempt <= $maxAttempts);
        return false;
    }
    private static function formatBibliography($bibliography)
    {
        $bibliography = trim($bibliography);
        $bibliography = trim($bibliography, '„“');
        $bibliography = strip_tags($bibliography);
        $bibliography = html_entity_decode($bibliography);        
        $bibliography = trim($bibliography);
        if (empty($bibliography)) {
            return null;
        }
        return $bibliography;
    }
    private function loadFromAPI()
    {
        $last_version = (ZoteroBibliography::max('zotero_version') - 1) ?? 0;
        $zoteroApi =  config('zotero.import.zotero_limit');
        $step = config('zotero.import.zotero_limit');
        $max = count(
            explode("\n", file_get_contents(config('zotero.import.url') . '?format=keys&itemType=-attachment+||+note&since=' . $last_version))
        ) - 1;
        $x = 0;
        $i = 0;
        Log::info('Downloading zotero takes a long time, take a tea/coffee and relax');
        $zotero_input = [];
        for ($i = $x; $i <= $max; $i = $i + $step) {
            $update = false;
            $zotero_url = config('zotero.import.url') . '?format=json&start=' . $i . '&since=' . $last_version . '&style=https://corpuscoranicum.de/zotero/corpus-coranicum.csl&include=bib&itemType=-attachment+||+note&sort=dateModified&direction=asc&limit=' . $step;

            $zotero_json = self::getZoteroData($zotero_url);
            # count the new entrys
            $j = 0;
            # loop: every zotero index 
            if ($zotero_json !== false) {
                Log::info('zotero download: ' . ($i + count($zotero_json)) . '/' . $max . '');
                foreach ($zotero_json as $entry) {
                    $bibliography = self::formatBibliography($entry['bib']);
                    // $zoteroItem["short_cite"] = "";
                    if (!empty($bibliography)) {
                        $zotero_input[] = [
                            'zotero_key' => $entry['key'],
                            'zotero_version' => $entry['version'],
                            'citation' => $bibliography,
                            'short_citation' => "(" . ($entry['meta']['creatorSummary'] ?? "Keine Kurzreferenz generierbar") . " " . ($entry['meta']['parsedDate'] ?? "Kein Datum generierbar") . ": PN)",
                        ];
                    }
                    $j++;
                }
                if (!empty($zotero_input)) {
                    collect($zotero_input)
                        ->map(function (array $row) {
                            return Arr::only($row, ['zotero_key', 'zotero_version', 'citation','short_citation']);
                        })
                        ->chunk(100)
                        ->each(function (Collection $chunk) {
                            ZoteroBibliography::upsert($chunk->toArray(), 'zotero_key');
                        });
                    $zotero_input = [];
                }
            } else {
                Log::error('zotero:download: ' . $zotero_url . ' failed');
            }
        }
    }
    public function handle()
    {
        $start = microtime(true);
        $data = self::loadFromAPI();
        $querytime = microtime(true) - $start;
        Log::info('Zotero script querytime: ' . $querytime . '');
        return Command::SUCCESS;
    }
}
