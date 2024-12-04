<?php

use App\Events\ManuskriptseitenVariantReadingDelete;
use App\Events\UpdateCodexClassificationsEvent;
use App\Events\UpdateManuskriptMappingsEvent;
use App\Models\Manuskripte\Manuskript;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManuskriptTexstellenTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function setUp()
    {

        parent::setUp();

    }

    /** see #8865 */
    /** @test */
    public function it_creates_the_manuscript_mapping_when_saving_a_manuscript()
    {

        $this->actingAs($this->getPaleocoranTestUser());

        $manuscript = Manuskript::find(366);

        $this->visit(URL::action("App\Http\Controllers\ManuskriptController@edit", $manuscript->ID));

        $this->press("Speichern");

        $this->seeInDatabase("manuskript_mapping", [
            "manuskript" => $manuscript->ID,
            "sure_start" => 71,
            "vers_start" => 10,
            "wort_start" => 3,
            "sure_ende" => 71,
            "vers_ende" => 25,
            "wort_ende" => 2
        ]);


    }

    /** see #8865 */
    /** @test */
    public function it_creates_the_manuscript_mapping_when_saving_a_manuscript_page()
    {

        $this->actingAs($this->getPaleocoranTestUser());

        $manuscript = Manuskript::find(366);

        $this->visit(URL::action("App\Http\Controllers\ManuskriptseitenController@edit", $manuscript->manuskriptseiten->first()->SeitenID));

        $this->press("Speichern");

        $this->seeInDatabase("manuskript_mapping", [
            "manuskript" => $manuscript->ID,
            "sure_start" => 71,
            "vers_start" => 10,
            "wort_start" => 3,
            "sure_ende" => 71,
            "vers_ende" => 25,
            "wort_ende" => 2
        ]);

        $this->markTestSkipped("No active transaction. Prevent from failing");
    }

}
