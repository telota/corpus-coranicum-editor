<?php

use App\Models\Umwelttexte\Belegstelle;
use App\Models\Umwelttexte\BelegstellenKategorie;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class BelegstellenKategorieUnitTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function setUp()
    {
        parent::setUp();
        if (!BelegstellenKategorie::count()) {
            Artisan::call('umwelttexte:create-kategorien');
        }
    }

    /** @test */
    public function it_has_Belegstellen()
    {
        $umwelttext = factory(Belegstelle::class)->create();
        $category = BelegstellenKategorie::find($umwelttext->kategorie);
        $this->assertGreaterThan(0, $category->belegstellen->count());
    }

    /** @test */
    public function a_Belegstelle_has_a_category()
    {
        $umwelttext = factory(Belegstelle::class)->create();
        $this->assertEquals($umwelttext->kategorie, $umwelttext->themenKategorie->id);
    }

}
