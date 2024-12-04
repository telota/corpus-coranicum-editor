<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class KorantextstellenTest extends TestCase
{

    use DatabaseTransactions;

    private function init()
    {

        $this->actingAs($this->getPaleocoranTestUser())
            ->visit(URL::action("App\Http\Controllers\KoranController@edit", [21, 22, 5]));
    }

    /** @test */
    public function it_sees_the_coordinate()
    {
        $this->init();

        $this->see("Sure 21, Vers 22, Wort 5");
        $this->see("021:022:005");

    }

    /** @test */
    public function it_can_change_the_transcription_of_the_print_version()
    {
        $this->init();

        $target = "ʾilla";

        $this->type($target, "transcription");

        $this->press("Speichern");

        $this->seePageIs(URL::action("App\Http\Controllers\KoranController@indexBySura", 21));

        $this->seeInDatabase("lc_kkoran", [
            "sure" => 21,
            "vers" => 22,
            "wort" => 5,
            "transkription" => $target
        ]);

        $this->see($target);

        $this->markTestSkipped("No active transaction. Prevent from failing");

    }

    /** @test */
    public function it_throws_a_flash_message_when_the_input_has_no_value()
    {

        $this->init();

        $this->type("", "transcription");

        $this->press("Speichern");

        $this->see("The transcription field is required");

    }

    /** @test */
    public function it_sees_links_to_edit_a_koranstelle()
    {
        $this->init();

        $this->visit(URL::action("App\Http\Controllers\KoranController@indexBySura", 21));

        $this->see(URL::action("App\Http\Controllers\KoranController@edit", [21, 22, 5]));

        $this->markTestSkipped("No active transaction. Prevent from failing");
    }

}
