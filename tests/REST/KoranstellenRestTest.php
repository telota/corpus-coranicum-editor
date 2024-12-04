<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class KoranstellenRestTest extends TestCase
{


    /** @test */
    public function setUp()
    {

        parent::setUp();

        $this->actingAs($this->getPaleocoranTestUser());


    }


    /** @test */
    public function it_can_fetch_the_max_verse_of_a_sura()
    {


        $this->get(URL::action("App\Http\Controllers\AjaxController@getVerse", ["sure" => 1]))
            ->seeJson()
            ->see(7);

        $this->get(URL::action("App\Http\Controllers\AjaxController@getVerse", ["sure" => 2]))
            ->seeJson()
            ->see(286);

        $this->get(URL::action("App\Http\Controllers\AjaxController@getVerse", ["sure" => 114]))
            ->seeJson()
            ->see(6);

    }

    /** @test */
    public function it_can_fetch_all_words_of_a_given_verse()
    {

        $this->get(URL::action("App\Http\Controllers\AjaxController@getWords", ["sure" => 1, "vers" => 1]))
            ->seeJson([
                "wort" => 1,
                "transkription" => "bi-smi ",
                "arab" => "بِسۡمِ"
            ])
            ->seeJson([
                "wort" => 4,
                "transkription" => "r-raḥīmi ",
                "arab" => "ٱلرَّحِيمِ"
            ]);

    }

}
