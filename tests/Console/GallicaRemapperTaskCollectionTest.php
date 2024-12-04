<?php

use App\Console\Commands\Helpers\GallicaRemapperTaskCollection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GallicaRemapperTaskCollectionTest extends TestCase
{


    public $taskCollection;

    /** @test */
    public function setUp()
    {
        parent::setUp();
        $this->markTestSkipped(
            'Console test. Data is now corrected and this test is obsolete.'
        );
        $this->taskCollection = new GallicaRemapperTaskCollection(
            Storage::get("tests/gallica_correction_operations_test.csv")
        );

    }

    /** @test */
    public function it_only_leaves_the_operation_indicator()
    {
        foreach ($this->taskCollection->tasks as $manuscriptId => $tasks) {
            foreach ($tasks as $task) {
                $this->assertTrue(in_array($task["operation"], ["I", "P", "H", "N", "D"]));
            }
        }
    }

    /** @test */
    public function it_only_accepts_harvesting_tasks_from_gallica()
    {
        foreach ($this->taskCollection->tasks as $manuscriptId => $tasks) {
            foreach ($tasks as $task) {
                if ($task["operation"] == "H") {
                    $this->assertTrue(str_contains($task["gallica_link"], "gallica"));
                }
            }
        }
    }

    /** @test */
    public function it_groups_the_manuscripts_by_their_id()
    {
        // Edit 28 different manuscripts in total
        $this->assertCount(28, $this->taskCollection->tasks);
        $this->assertCount(4, $this->taskCollection->tasks[555]);
    }

    /** @test */
    public function it_rearranges_the_tasks_by_type()
    {

        $taskCollection = new GallicaRemapperTaskCollection(
            Storage::get("tests/gallica_correction_operations_processed_test_2017-09-08_11-14.csv"),
            true
        );

        $exampleTasks = $taskCollection->tasks[31];

        $this->assertEquals("P", $exampleTasks[0]["operation"]);
        $this->assertEquals("H", $exampleTasks[1]["operation"]);

        $exampleTasks2 = $taskCollection->tasks[579];


        $this->assertEquals("H", $exampleTasks2[0]["operation"]);
        $this->assertEquals("H", $exampleTasks2[1]["operation"]);
        $this->assertEquals("N", $exampleTasks2[2]["operation"]);


    }

    /** @test */
    public function it_rearranges_the_page_moving_tasks_descending()
    {

        $taskCollection = new GallicaRemapperTaskCollection(
            Storage::get("tests/gallica_correction_operations_processed_test_2017-09-08_11-14.csv"),
            true
        );

        $exampleTasks = $taskCollection->tasks[555];

        $this->assertEquals(40, $exampleTasks[0]["folio_start_old"]);
        $this->assertEquals(39, $exampleTasks[1]["folio_start_old"]);
        $this->assertEquals(38, $exampleTasks[2]["folio_start_old"]);
        $this->assertEquals(37, $exampleTasks[3]["folio_start_old"]);

    }

    /** @test */
    public function it_ignores_entries_that_have_already_been_processed()
    {

        $this->assertArrayNotHasKey(570, $this->taskCollection->tasks);

    }

    /** @test */
    public function it_includes_already_processed_tasks_when_specified()
    {

        $taskCollection = new GallicaRemapperTaskCollection(
            Storage::get("tests/gallica_correction_operations_test.csv"), true);

        $this->assertArrayHasKey(570, $taskCollection->tasks);

    }

    /** @test */
    public function it_sees_deletion_tasks()
    {

        $deletionTasks = array_filter($this->taskCollection->tasks[757], function($task) {
            return $task["operation"] == "D";
        });

        $this->assertCount(1, $deletionTasks);

    }

    /** see #8896 */
    /** @test */
    public function it_schedules_deletion_tasks_before_harvesting_tasks()
    {

        $tasks = $this->taskCollection->tasks[598];

        $allowedOperations = [
            "D" => 0,
            "I" => 1,
            "P" => 2,
            "H" => 3,
            "N" => 4
        ];

        $this->assertEquals("D", $tasks[0]["operation"]);
        $this->assertEquals("N", $tasks[count($tasks) - 1]["operation"]);





    }
    
}
