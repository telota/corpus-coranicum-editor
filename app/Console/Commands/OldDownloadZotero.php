<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Download all bibliography information from Zotero
 * Class DownloadZotero
 * @package app\Console\Commands
 */
class OldDownloadZotero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oldzotero:download {--refresh : Reload all entries}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download the latest changes from Zotero. Use "--refresh" to reload all entries';

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
     * @throws \Throwable
     */
    public function handle()
    {
        $zoteroApi = "https://api.zotero.org/groups/265673";

        // Get the highest "version" from Zotero, i.e. only the latest changes since the last sync
        $highestVersion = Cache::get("zotero-highest-version", 0);

        // Array to store everything in
        $itemArray = Cache::get('zotero-items', array());

        // In case everything needs to be refreshed, forget everything and fetch everything anew
        if ($this->option("refresh")) {
            $highestVersion = 0;
            $itemArray = array();
        }

        // Placeholder variable to store the newest highest version later
        $newHighestVersion = $highestVersion;

        // Estimate how many entries will be fetched
        $numberOfItems = count(
            explode("\n", file_get_contents($zoteroApi . "/items?format=keys&since={$highestVersion}"))
        );

        $counter = 0;
        $limitSize = 100;
        $ccStyle = urlencode("https://corpuscoranicum.de/zotero/corpus-coranicum.csl");

        $progress = $this->output->createProgressBar($numberOfItems);

        while ($counter < $numberOfItems) {
            $zoteroItemListUrl = $zoteroApi . "/items?" .
                "sort=creator&" .
                "format=json&" .
                "limit={$limitSize}&" .
                "start={$counter}&" .
                "include=bib,data&" .
                "style={$ccStyle}&" .
                "itemType=-attachment&" .
                "since={$highestVersion}";

            // The Zotero API is wonky. Make sure to retry the request in case it fails
            $zoteroResponse = false;
            $retries = 0;
            while ($zoteroResponse === false && $retries <= 10) {
                // Suppress the error message when the Zotero API fails and retry again. Unfortunately, this was the
                // cleanest way
                $zoteroResponse = @file_get_contents($zoteroItemListUrl);
                $retries++;
                if ($zoteroResponse === false) {
                    echo "Zotero API unavailable. Retrying...\n";
                    sleep(10);
                }
            }

            // Decode the results from the API to JSON
            $zoteroItemList = json_decode($zoteroResponse);

            // Iterate over the result set
            foreach ($zoteroItemList as $item) {
                // Skip if the item is not a real entry
                if (
                    $item->data->itemType == "note" ||
                    $item->data->itemType == "attachment"
                ) {
                    continue;
                }

                // Extract the bibliographic information
                $zoteroItem = array();
                $zoteroItem["long"]  = trim(strip_tags($item->bib));
                $zoteroItem["bib"] = $item->bib;

                // Modify short references
                if (property_exists($item->meta, "creatorSummary") && property_exists($item->meta, "parsedDate")) {
                    $zoteroItem["short"] = "(" . $item->meta->creatorSummary . " " .
                        $item->meta->parsedDate . ")";

                    $zoteroItem["short_cite"] = "(" . $item->meta->creatorSummary . " " .
                        $item->meta->parsedDate . ": PN)";
                } else {
                    $zoteroItem["short"] = "(Keine Kurzreferenz generierbar)";
                    $zoteroItem["short_cite"] = "(Keine Kurzreferenz generierbar)";
                }

                $itemArray[$item->key] = $zoteroItem;

                // Set the highest version
                if ($item->version >= $newHighestVersion) {
                    $newHighestVersion = $item->version;
                    Cache::forever('zotero-highest-version', $newHighestVersion);
                }
            }

            $counter += $limitSize;
            $progress->advance($limitSize);
        }

        $progress->finish();

        Cache::forever('zotero-items', $itemArray);

        $selectForm = view("includes.zotero.select", [
            "label" => "Literatur",
            "items" => $itemArray
        ])->render();

        $bibliographyTable = view("includes.zotero.bibliography", [
            "label" => "Literatur",
            "items" => $itemArray
        ])->render();

        Storage::put("zotero/zotero.html", $selectForm);
        Storage::put("zotero/bibliography.html", $bibliographyTable);
        Storage::put("zotero/zoteroMapping.json", json_encode($itemArray));
    }
}
