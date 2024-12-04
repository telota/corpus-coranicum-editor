<?php

use App\Models\Manuskripte\Manuskript;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManuskriptUnitTest extends TestCase
{

    use DatabaseTransactions;

    private $manuskript;

    /** @test */
    public function setUp()
    {

        parent::setUp();

        $this->manuskript = Manuskript::find(150);

    }

    /** @test */
    public function it_has_manuscript_pages()
    {

        $this->assertNotNull($this->manuskript->manuskriptseiten);
        $this->assertCount(84, $this->manuskript->manuskriptseiten);

    }

    /** @test */
    public function it_can_get_a_manuscript_pages_range_when_no_parameters_are_given()
    {

        $this->assertNotNull($this->manuskript->getManuskriptseitenInRange());
        $this->assertCount(84, $this->manuskript->getManuskriptseitenInRange());

    }

    /** @test */
    public function it_can_get_a_manuscript_pages_range_with_only_the_starting_folio_given()
    {
        $this->markTestIncomplete("Must be revisted");
        $this->assertNotNull($this->manuskript->getManuskriptseitenInRangeFromFolio(15));
        $this->assertCount(56, $this->manuskript->getManuskriptseitenInRangeFromFolio(15));


        $this->assertNotNull($this->manuskript->getManuskriptseitenInRange(15));
        $this->assertCount(56, $this->manuskript->getManuskriptSeitenInRange(15));

    }

    /** @test */
    public function it_can_get_a_manuscript_pages_range_with_the_starting_folio_and_page_given()
    {

        $this->assertCount(55, $this->manuskript->getManuskriptseitenInRangeFromPage(15, "v"));
        $this->assertCount(55, $this->manuskript->getManuskriptSeitenInRange(15, "v"));

        $firstPage = $this->manuskript->getManuskriptseitenInRange(15, "v")->first();
        $this->assertEquals(15, $firstPage->Folio);
        $this->assertEquals("v", $firstPage->Seite);

    }

    /** @test */
    public function it_can_get_a_manuscript_page_range_to_a_given_ending_folio()
    {

        $this->assertCount(30, $this->manuskript->getManuskriptseitenInRangeToFolio(15));

    }

    /** @test */
    public function it_can_get_a_manuscript_page_range_to_a_given_ending_page()
    {

        $this->assertCount(29, $this->manuskript->getManuskriptseitenInRangeToPage(15, "r"));


    }

    /** @test */
    public function it_can_get_manuscript_pages_range_with_all_parameters_given()
    {
        $this->assertCount(12, $this->manuskript->getManuskriptseitenInRange(15, "r", 20, "v"));
        $this->assertCount(10, $this->manuskript->getManuskriptseitenInRange(15, "v", 20, "r"));

    }

    /** @test */
    public function it_fails_fetching_a_manuscript_pages_range_when_the_ending_page_occurs_before_the_starting_page()
    {

        $this->setExpectedException(QueryException::class);
        $this->manuskript->getManuskriptseitenInRange(20, "r", 15, "v");

    }

    /** @test */
    public function it_fails_fetching_a_manuscript_pages_range_when_illegal_page_numbers_are_given()
    {

        $this->setExpectedException(QueryException::class);
        $this->manuskript->getManuskriptseitenInRange(20, "something", 21, "wrong");

    }

    /** @test */
    public function it_can_fetch_a_list_of_page_numbers()
    {

        $targetOne = [
            ["Folio" => 1, "Seite" => "r"],
            ["Folio" => 1, "Seite" => "v"],
            ["Folio" => 2, "Seite" => "r"],
            ["Folio" => 2, "Seite" => "v"]
        ];

        $targetTwo = [
            ["Folio" => 1, "Seite" => "v"],
            ["Folio" => 2, "Seite" => "r"]
        ];

        $this->assertEquals($targetOne, Manuskript::createPageRange(1 , "r", 2, "v"));
        $this->assertEquals($targetTwo, Manuskript::createPageRange(1 , "v", 2, "r"));

    }

    /** @test */
    public function it_can_create_a_new_manuscript_page_with_a_given_folio_and_page_number()
    {

        $manuskript = factory(Manuskript::class)->create();

        $manuskript->createNewManuscriptPages(1, "r");

        $this->assertCount(1, $manuskript->manuskriptseiten);
        $this->assertEquals($manuskript->ID, $manuskript->manuskriptseiten->first()->ManuskriptID);

    }

    /** @test */
    public function it_can_create_multiple_new_manuscript_pages_when_a_folio_range_is_given()
    {

        $manuskript = factory(Manuskript::class)->create();

        $manuskript->createNewManuscriptPages(1, "r", 3, "v");


        $this->assertCount(6, $manuskript->manuskriptseiten);


        $manuskriptIncremental = factory(Manuskript::class)->create();

        $manuskriptIncremental->createNewManuscriptPages(1, "r", 3, "v");
        $manuskriptIncremental->createNewManuscriptPages(3, "r", 4, "v");

        $this->assertCount(8, $manuskriptIncremental->manuskriptseiten);

    }

}
