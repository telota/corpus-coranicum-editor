<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateManuscript33Test extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_merges_the_double_occurring_recto_folios()
    {
        $this->markTestSkipped("One time fix");

        Artisan::call('fix:manuscript-33');

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 23576,
            "manuskriptseite" => 4047
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 23626,
            "manuskriptseite" => 4072
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 38757
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 38807
        ]);
    }

}
