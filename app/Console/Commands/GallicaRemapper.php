<?php

namespace App\Console\Commands;

use App\Console\Commands\Helpers\CsvReader;
use App\Console\Commands\Helpers\GallicaRemapperTaskCollection;
use App\Models\Helpers\GallicaDownloader;
use App\Models\Manuskripte\Manuskript;
use App\Models\Manuskripte\Manuskriptseite;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class GallicaRemapper extends Command
{

    const OPERATION_TYPE_DELETE_PAGES = "D";
    const OPERATION_TYPE_MOVE_IMAGES = "I";
    const OPERATION_TYPE_MOVE_PAGES = "P";
    const OPERATION_TYPE_HARVEST = "H";
    const OPERATION_TYPE_NEW_PAGES = "N";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gallica:remap {operation?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixes some issues with wrong gallica mappings';

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

        $taskCollection = new GallicaRemapperTaskCollection(Storage::get("gallica/gallica_correction_operations.csv"));

        foreach($taskCollection->tasks as $manuscriptId => $tasks)
        {

            foreach($tasks as $taskIndex => $task)
            {

                if ($task["operation"] == self::OPERATION_TYPE_MOVE_PAGES)
                {
                    if (is_null($this->argument("operation")) || $this->argument("operation") == self::OPERATION_TYPE_MOVE_PAGES)
                    {
                        echo "Moving manuscript pages for #{$task["manuscript_id_old"]}\n";
                        $this->remapManuscriptPages($task);
                        $taskCollection->tasks[$manuscriptId][$taskIndex]["processed"] = 1;
                    }
                }

                else if ($task["operation"] == self::OPERATION_TYPE_HARVEST)
                {

                    if (is_null($this->argument("operation")) || $this->argument("operation") == self::OPERATION_TYPE_HARVEST)
                    {
                        echo "Harvesting new manuscript images for #{$task["manuscript_id_old"]}\n";
                        $this->downloadManuscripts($task);
                        $taskCollection->tasks[$manuscriptId][$taskIndex]["processed"] = 1;

                    }

                }

                else if ($task["operation"] == self::OPERATION_TYPE_NEW_PAGES)
                {

                    if (is_null($this->argument("operation")) || $this->argument("operation") == self::OPERATION_TYPE_NEW_PAGES)
                    {
                        echo "Creating new manuscript pages for #{$task["manuscript_id_old"]}\n";
                        $this->createNewPages($task);
                        $taskCollection->tasks[$manuscriptId][$taskIndex]["processed"] = 1;
                    }

                }

                else if ($task["operation"] == self::OPERATION_TYPE_DELETE_PAGES)
                {

                    if (is_null($this->argument("operation")) || $this->argument("operation") == self::OPERATION_TYPE_DELETE_PAGES)
                    {
                        echo "Deleting pages for manuscript #{$task["manuscript_id_old"]}\n";
                        $this->deletePages($task);
                        $taskCollection->tasks[$manuscriptId][$taskIndex]["processed"] = 1;
                    }

                }

            }

        }

        $this->writeProcessedCsv($taskCollection);

    }

    /**
     * Move manuscript pages to bis/ter, outside of the usual r/v pagination
     * @param $task
     */
    private function moveManuscriptsToBisAndTer($task)
    {

        $manuscriptPagesOld = Manuskript::find(intval($task["manuscript_id_old"]))->getManuskriptseitenInRange(
            intval($task["folio_start_old"]), $task["seite_start_old"],
            intval($task["folio_end_old"]), $task["seite_end_old"]
        );

        foreach($manuscriptPagesOld as $manuscriptPage)
        {

            if ($manuscriptPage->Seite == "r")
            {
                $manuscriptPage->Seite = $task["seite_start_new"];
            }

            if ($manuscriptPage->Seite == "v")
            {
                $manuscriptPage->Seite = $task["seite_end_new"];
            }

            $manuscriptPage->Folio = intval($task["folio_start_new"]);
            $manuscriptPage->FolioundSeite = $manuscriptPage->Folio . $manuscriptPage->Seite;

            $manuscriptPage->save();

        }


    }

    /**
     * Assign new manuscript pages
     * @param $task
     */
    private function remapManuscriptPages($task)
    {

        if (in_array($task["seite_start_new"], ["bis", "ter"]) || in_array($task["seite_end_new"], ["bis", "ter"]))
        {
            $this->moveManuscriptsToBisAndTer($task);
            return;
        }

        $oldRange = Manuskript::createPageRange(
            intval($task["folio_start_old"]), $task["seite_start_old"],
            intval($task["folio_end_old"]), $task["seite_end_old"]
        );

        $newRange = Manuskript::createPageRange(
            intval($task["folio_start_new"]), $task["seite_start_new"],
            intval($task["folio_end_new"]), $task["seite_end_new"]
        );

        // Go from end to beginning to avoid overlays
        for ($i = count($oldRange) -1; $i >= 0; $i--)
        {

            $page = Manuskriptseite::where([
                "ManuskriptID" => $task["manuscript_id_old"],
                "Folio" => $oldRange[$i]["Folio"],
                "Seite" => $oldRange[$i]["Seite"]
            ])->first();


            $page->ManuskriptID = $task["manuscript_id_new"];
            $page->Folio = $newRange[$i]["Folio"];
            $page->Seite = $newRange[$i]["Seite"];
            $page->FolioundSeite = $page->Folio . $page->Seite;
            $page->save();

        }

    }

    /**
     * Download new manuscript pages
     * @param $task
     */
    private function downloadManuscripts($task)
    {

        $downloader = new GallicaDownloader(
            $task["gallica_link"], $task["gallica_start"], $task["gallica_end"],
            $task["manuscript_id_old"],
            $task["folio_start_old"], $task["seite_start_old"],
            $task["folio_end_old"], $task["seite_end_old"]
            );

        $downloader->downloadImages();

    }

    /**
     * Create new manuscript pages in range
     * @param $task
     */
    private function createNewPages($task)
    {

        Manuskript::find($task["manuscript_id_old"])
            ->createNewManuscriptPages($task["folio_start_new"], $task["seite_start_new"], $task["folio_end_new"], $task["seite_end_new"]);

    }

    /**
     * Mass delete manuscript pages
     * @param $task
     */
    private function deletePages($task)
    {

        $manuscriptPages = Manuskript::find($task["manuscript_id_old"])
            ->getManuskriptseitenInRange($task["folio_start_old"], $task["seite_start_old"], $task["folio_end_old"], $task["seite_end_old"]);

        foreach($manuscriptPages as $manuscriptPage)
        {
            $manuscriptPage->delete();
        }

    }

    /**
     * Write processed information to file
     * @param $taskCollection
     */
    private function writeProcessedCsv(GallicaRemapperTaskCollection $taskCollection)
    {

        $output = join("\t", $taskCollection->fields) . "\n";

        foreach($taskCollection->tasks as $manuscriptId => $manuscriptTasks)
        {

            foreach($manuscriptTasks as $task)
            {

                $output .= join("\t", array_values($task)) . "\n";

            }

        }

        $outputName = "gallica_correction_operations_processed_" . Carbon::now('Europe/Berlin')->format('Y-m-d_H-i') . ".csv";

        Storage::put("gallica/" . $outputName, $output);

    }

    private function checkPageRanges()
    {
        $csv = CsvReader::readCsv(Storage::get("gallica/gallica_correction_new_images.csv"));
        $counter = 14;
        foreach ($csv as $entry)
        {
            $counter++;
            $downloader = new GallicaDownloader(
                $entry["gallica_link"], $entry["gallica_start"], $entry["gallica_end"],
                $entry["manuscript_id"],
                $entry["folio_start"], $entry["seite_start"],
                $entry["folio_end"], $entry["seite_end"]
            );

            $gr = $downloader->getGallicaRange();
            $pageRange = Manuskript::createPageRange($entry["folio_start"], $entry["seite_start"], $entry["folio_end"], $entry["seite_end"]);

            if (count($gr) != count($pageRange))
            {
                echo "Uneven ranges on line " . $counter . ". Gallica (" . count($gr) . ") - CC (" . count($pageRange) . ") \n";
            }

        }

    }


}
