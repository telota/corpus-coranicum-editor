<?php

use App\Models\Konkordanz;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class KonkordanzTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp() {
        parent::setUp();
        $this->markTestSkipped(
            'Console test. Data is now corrected and this test is obsolete.'
        );
    }

    /** @test */
    public function it_can_save_cc_cordinates_to_the_table()
    {

        Artisan::call("konkordanz:add-coordinates");

        $singleStelle = Konkordanz::where(["suraverse" => 1001, "word_num" => 1])->first();
        $this->assertEquals(1, $singleStelle->sure_cc);
        $this->assertEquals(1, $singleStelle->vers_cc);
        $this->assertEquals(1, $singleStelle->wort_cc);

        $doubleStelle = Konkordanz::where(["suraverse" => 99004, "word_num" => 3])->first();
        $this->assertEquals(99, $doubleStelle->sure_cc);
        $this->assertEquals(4, $doubleStelle->vers_cc);
        $this->assertEquals(3, $doubleStelle->wort_cc);

        $tripleStelle = Konkordanz::where(["suraverse" => 113005, "word_num" => 4])->first();
        $this->assertEquals(113, $tripleStelle->sure_cc);
        $this->assertEquals(5, $tripleStelle->vers_cc);
        $this->assertEquals(4, $tripleStelle->wort_cc);


    }

    /** @test */
    public function it_can_save_dmg_base_to_the_table()
    {

        Artisan::call("konkordanz:dmg-conversion");

        $singleStelle = Konkordanz::where(["suraverse" => 1001, "word_num" => 1])->first();
        $this->assertEquals("sm", $singleStelle->base_cc);

        $doubleStelle = Konkordanz::where(["suraverse" => 99004, "word_num" => 3])->first();
        $this->assertEquals("ʾaḫbār", $doubleStelle->base_cc);

        $tripleStelle = Konkordanz::where(["suraverse" => 113005, "word_num" => 4])->first();
        $this->assertEquals("ʾiḏā", $tripleStelle->base_cc);



    }

}
