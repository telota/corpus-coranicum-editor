<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateManuscript771Test extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_merges_the_two_1r_folios_into_manuscript_page_36029()
    {
        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call("fix:manuscript-771");

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 20758,
            "manuskriptseite" => 36029
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 20760,
            "manuskriptseite" => 36029
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 36031
        ]);
    }

    /** @test */
    public function it_merges_the_two_1v_folios_into_manuscript_page_36030()
    {
        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call("fix:manuscript-771");

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 20759,
            "manuskriptseite" => 36030
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 20761,
            "manuskriptseite" => 36030
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 36032
        ]);
    }
    
    /** @test */
    public function it_merges_manuscript_pages_36080_and_36081_together_into_fol_25v()
    {
        Artisan::call('fix:manuscript-771');

        $this->seeInDatabase("manuskriptseiten", [
            "SeitenID" => 36080,
            "Folio" => "25",
            "Seite" => "v",
            "FolioundSeite" => "25v"
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 20809,
            "manuskriptseite" => 36080
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 20810,
            "manuskriptseite" => 36080
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 36081
        ]);
    }
}
