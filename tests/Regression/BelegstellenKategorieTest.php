<?php

namespace Tests\Regression;

use App\Models\Umwelttexte\Belegstelle;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class BelegstellenKategorieTest extends TestCase
{
    use DatabaseTransactions;

    /** @test #9833 */
    public function it_nullifies_the_category_attribute_if_a_wrong_attribute_was_given()
    {
        $umwelttext = factory(Belegstelle::class)->create([
            "kategorie" => "D15"
        ]);

        $failureMessage = "D15: --- Kategorie ist ungültig / existiert nicht ---.";
        $this->assertEquals($failureMessage, $umwelttext->fullCategoryName);

    }
}
