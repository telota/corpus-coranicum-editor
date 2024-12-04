<?php

use App\Models\Umwelttexte\Belegstelle;
use App\Models\Umwelttexte\BelegstellenKategorie;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class BelegstellenKategorieTest
 */
class BelegstellenKategorieTest extends TestCase
{
    use DatabaseTransactions;

    private $umwelttext;
    private $kategorie;

    /** @test */
    public function setUp()
    {
        parent::setUp();
        $this->umwelttext = factory(\App\Umwelttexte\Belegstelle::class)->create();
        $this->kategorie = $this->umwelttext->themenKategorie;
        $this->actingAs($this->getPaleocoranTestUser());
    }
    
    /** @test */
    public function it_sees_the_category_on_the_show_view()
    {
        $this->visit(URL::action("App\Http\Controllers\UmwelttexteController@show", $this->umwelttext->ID));
        $this->see($this->kategorie->id);
        $this->see($this->kategorie->name);
    }

    /** @test */
    public function it_can_create_a_new_category(){
        $this->visit("/belegstellenkategorie");
        $this->click("Neu");
        $this->see("Kategorie erstellen");
        $this->type("Test Kategorie", 'name');
        $this->select("0", "supercategory");
        $this->press("Speichern");
        $this->seeInDatabase('belegstellen_kategorie', [
            'name' => "Test Kategorie"
        ]);
    }

    public function it_can_change_supercategory(){
        $this->visit("/belegstellenkategorie/edit/247");
        $this->select("243", "supercategory");
        $this->press("Speichern");
        $this->seeInDatabase("belegstellen_kategorie",[
            "id" => 247,
            "supercategory" => 243
        ]);
    }
}
