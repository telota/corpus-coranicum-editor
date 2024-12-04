<?php
/**
 * Created by PhpStorm.
 * User: suchmaske
 * Date: 31.08.17
 * Time: 09:26
 */

namespace App\Console\Commands\Helpers;


use App\Models\Manuskripte\Manuskript;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GallicaRemapperTaskCollection
{

    use DatabaseTransactions;

    public $tasks;
    public $fields;
    private $allowProcessedTasks = false;

    private $allowedOperations = [
        "D" => 0,
        "I" => 1,
        "P" => 2,
        "N" => 3,
        "H" => 4
    ];

    public function __construct($taskFilePath, $allowProcessedTasks = false)
    {

        $this->allowProcessedTasks = $allowProcessedTasks;
        $this->sortTasks($taskFilePath);

    }

    private function sortTasks($taskFilePath)
    {

        $tasks = CsvReader::readCsv($taskFilePath);

        $this->fields = array_keys($tasks[0]);

        $this->tasks = array_filter($tasks, function($task) {

            $allowed = in_array($task["operation"], array_keys($this->allowedOperations));
            $newTask = (!$task["processed"]);

            if ($this->allowProcessedTasks)
            {
                $newTask = true;
            }

            $fromGallicaIfHarvest = true;

            if ($task["operation"] == "H")
            {
                $fromGallicaIfHarvest = str_contains($task["gallica_link"], "gallica");
            }

            return ($allowed && $newTask && $fromGallicaIfHarvest);
        });

        $this->groupByManuscriptId();
        $this->rearrangeManuscriptMovingTasks();

    }

    private function groupByManuscriptId()
    {

        $taskList = [];

        foreach($this->tasks as $task)
        {

            $manuscriptId = $task["manuscript_id_old"];

            if (!(in_array($manuscriptId, array_keys($taskList))))
            {
                $taskList[$manuscriptId] = [];
            }


            if ($this->validateMovingTask($task))
            {
                array_push($taskList[$manuscriptId], $task);
            }


        }

        $this->tasks = $taskList;

    }


    private function rearrangeManuscriptMovingTasks()
    {

        foreach($this->tasks as $manuscript => $manuscriptTasks)
        {

            $tasks = $this->sortTaskOrderAlternative($manuscriptTasks);
            //$tasks = $manuscriptTasks;

            //usort($tasks, array($this, "sortTaskOrder"));
            //usort($tasks, array($this, "sortMovingPagesTaskOrder"));

            $this->tasks[$manuscript] = $tasks;

        }

    }

    private function sortTaskOrderAlternative($tasks)
    {

        $deletionTasks = array_filter($tasks, function($task) {
            return $task["operation"] == "D";
        });

        $moveImagesTasks = array_filter($tasks, function($task) {
            return $task["operation"] == "I";
        });

        $movePagesTasks = array_filter($tasks, function($task) {
            return $task["operation"] == "P";
        });

        usort($movePagesTasks, array($this, "sortMovingPagesTaskOrder"));

        $harvestImagesTasks = array_filter($tasks, function($task) {
            return $task["operation"] == "H";
        });

        $newPagesTasks = array_filter($tasks, function($task) {
            return $task["operation"] == "N";
        });

        return array_merge($deletionTasks, $moveImagesTasks, $movePagesTasks, $harvestImagesTasks, $newPagesTasks);

    }

    /**
     * Make sure to move manuscript pages before harvesting new ones
     *
     * @param $taskBefore
     * @param $taskAfter
     */
    private function sortTaskOrder($taskBefore, $taskAfter)
    {

        $taskIdBefore = $this->allowedOperations[$taskBefore["operation"]];
        $taskIdAfter = $this->allowedOperations[$taskAfter["operation"]];

        if ($taskIdBefore == $taskIdAfter) {
            return 0;
        }

        return ($taskIdBefore < $taskIdAfter) ? -1 : 1;

    }

    private function sortMovingPagesTaskOrder($taskBefore, $taskAfter)
    {

        if ($taskBefore["operation"] != "P" || $taskAfter["operation"] != "P")
        {
            return 0;
        }

        if (intval($taskBefore["folio_start_old"]) < intval($taskBefore["folio_start_new"]))
        {
            return (intval($taskBefore["folio_start_old"]) < intval($taskAfter["folio_start_old"])) ? 1 : -1;
        }

    }

    private function validateMovingTask($task)
    {

        if ($task["operation"] != "P")
        {
            return true;
        }


        if (starts_with($task["seite_start_new"], "bis") || starts_with($task["seite_end_new"], "bis"))
        {
            return true;
        }

        if (starts_with($task["seite_start_new"], "ter") || starts_with($task["seite_end_new"], "ter"))
        {
            return true;
        }


        $manuscriptPages = Manuskript::createPageRange(
            intval($task["folio_start_old"]), $task["seite_start_old"],
            intval($task["folio_end_old"]), $task["seite_end_old"]
        );

        $newRange = Manuskript::createPageRange(
            intval($task["folio_start_new"]), $task["seite_start_new"],
            intval($task["folio_end_new"]), $task["seite_end_new"]
        );

        return (sizeof($manuscriptPages) == sizeof($newRange));

    }




}