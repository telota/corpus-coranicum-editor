<?php

use App\Models\Konkordanz;
use App\Models\Koranstelle;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class KonkordanzUnitTest extends TestCase
{

    /** @test */
    public function it_has_a_koranstelle()
    {
        $konkordanzStelle = Konkordanz::where(["suraverse" => 99004, "word_num" => 3])->first();

        $targetKoranstelle = Koranstelle::where(["sure" => 99, "vers" => 4, "wort" => 3])->first();

        $this->assertEquals($targetKoranstelle->sure, $konkordanzStelle->sure_cc);
        $this->assertEquals($targetKoranstelle->vers, $konkordanzStelle->vers_cc);
        $this->assertEquals($targetKoranstelle->wort, $konkordanzStelle->wort_cc);

        $this->assertEquals($targetKoranstelle, $konkordanzStelle->koranstelle);

    }

    /** @test */
    public function it_converts_rtk_to_dmg()
    {

        $this->assertEquals("yaʿbud", Konkordanz::rtkToDmg("ya&bud"));
        $this->assertEquals("mušrik", Konkordanz::rtkToDmg("mu(sh)rik"));

    }

}
