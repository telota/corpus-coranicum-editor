<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BelegstellenKategorieConsoleTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_creates_the_belegstellen_categories()
    {
        Artisan::call("umwelttexte:create-kategorien");

        $this->seeInDatabase("belegstellen_kategorie", [
            "id" => "A",
            "name" => "Altarabische Dichtung"
        ]);

        $this->seeInDatabase("belegstellen_kategorie", [
            "id" => "A1",
            "name" => "ʿAbīd b. al-ʾAbraṣ (6. Jh.)"
        ]);
    }
    
    /** @test */
    public function it_adds_categories_to_the_belegstellen()
    {
        Artisan::call("umwelttexte:create-kategorien");

        $this->seeInDatabase("belegstellen", [
            "ID" => 261,
            "kategorie" => "B20"
        ]);

        $this->seeInDatabase("belegstellen", [
            "ID" => 1269,
            "kategorie" => "N3"
        ]);
    }

}
