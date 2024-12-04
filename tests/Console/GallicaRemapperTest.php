<?php

use App\Models\Manuskripte\Manuskriptseiten;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GallicaRemapperTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp() {
        parent::setUp();
        $this->markTestSkipped(
            'Console test. Data is now corrected and this test is obsolete.'
        );
    }

    /** @test */
    public function it_moves_the_manuscripts_in_the_correct_order()
    {

        Artisan::call("gallica:remap", ["operation" => "P"]);


        // Manuskript 555, Folio 40 -> 42
        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 27921,
            "Folio" => 40,
            "Seite" => "r"
        ])->seeInDatabase("manuskriptseiten", [
           "SeitenID" => 27921,
           "Folio" => 42,
           "Seite" => "r"
        ]);

        // Manuskript 555, Folio 39 -> 41
        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 27919,
            "Folio" => 39,
            "Seite" => "r"
        ])->seeInDatabase("manuskriptseiten", [
            "SeitenID" => 27919,
            "Folio" => 41,
            "Seite" => "r"
        ]);

    }

    /** @test */
    public function it_moves_pages_to_bis_or_ter()
    {

        Artisan::call("gallica:remap", ["operation" => "P"]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 27957,
            "Folio" => 60,
            "Seite" => "r"
        ])->seeInDatabase("manuskriptseiten", [
            "SeitenID" => 27957,
            "Folio" => 59,
            "Seite" => "bis"
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 27958,
            "Folio" => 60,
            "Seite" => "v"
        ])->seeInDatabase("manuskriptseiten", [
            "SeitenID" => 27958,
            "Folio" => 59,
            "Seite" => "ter"
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 27959,
            "Folio" => 61,
            "Seite" => "r"
        ])->seeInDatabase("manuskriptseiten", [
            "SeitenID" => 27959,
            "Folio" => 60,
            "Seite" => "r"
        ]);

    }

    /** @test */
    public function it_harvests_the_gallica_images()
    {

        $examplePage = Manuskriptseiten::find(1199);

        // Before Harvest
        $this->assertCount(1, $examplePage->bilder);

        Artisan::call("gallica:remap");

        $this->assertCount(2, $examplePage->bilder);


    }

    /** @test */
    public function it_creates_new_pages()
    {

        Artisan::call("gallica:remap", ["operation" => "N"]);

        $this->assertCount(1, Manuskriptseiten::where([
            "ManuskriptID" => 579,
            "Folio" => 131,
            "Seite" => "r"
        ])->get());

        $this->assertCount(1, Manuskriptseiten::where([
            "ManuskriptID" => 560,
            "Folio" => 47,
            "Seite" => "r"
        ])->get());

        $this->assertCount(1, Manuskriptseiten::where([
            "ManuskriptID" => 560,
            "Folio" => 47,
            "Seite" => "v"
        ])->get());

        $this->assertCount(1, Manuskriptseiten::where([
            "ManuskriptID" => 560,
            "Folio" => 48,
            "Seite" => "r"
        ])->get());

        $this->assertCount(1, Manuskriptseiten::where([
            "ManuskriptID" => 560,
            "Folio" => 48,
            "Seite" => "v"
        ])->get());

    }

    /** @test */
    public function it_deletes_pages()
    {

        // Make sure page exists before deleting
        $this->seeInDatabase("manuskriptseiten", [
            "ManuskriptID" => 45,
            "Folio" => 1,
            "Seite" => "r"
        ]);

        Artisan::call("gallica:remap", ["operation" => "D"]);

        // Make sure page is deleted
        $this->dontSeeInDatabase("manuskriptseiten", [
            "ManuskriptID" => 45,
            "Folio" => 1,
            "Seite" => "r"
        ]);

    }


}
