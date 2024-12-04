<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class KoranUebersetzungTest extends TestCase
{
    use DatabaseTransactions;


    /** @test */
    public function setUp()
    {
        parent::setUp();
        $this->importTanzilTranslations();
    }

    /** @test */
    public function it_visits_index_page()
    {
        $this->visit(URL::action("App\Http\Controllers\DruckausgabeController@index"));
    }


    /** @test */
    public function it_visits_show_page_and_shows_the_right_translations_and_right_sure_vers()
    {
        $this->visit(URL::action("App\Http\Controllers\DruckausgabeController@showByVerse", [1, 1]));

        $this->see('001:001');

        $this->it_shows_translation_languages();

        $this->it_shows_the_correct_texts();
    }


    /** @test */
    public function it_visits_edit_page_and_shows_the_right_translations_and_right_sure_vers()
    {
        $this->visit(URL::action("App\Http\Controllers\DruckausgabeController@editByVerse", [1, 1]));

        $this->see('(Sure 1, Vers 1)');

        $this->it_shows_translation_languages();

    }


    /** @test */
    public function it_saves_translation_in_all_languages_into_database()
    {
        $this->visit(URL::action("App\Http\Controllers\DruckausgabeController@editByVerse", [1,1]));

        // english pickthall translation
        $original = "In the name of Allah, the Beneficent, the Merciful.";
        $target = "Sure 1 vers 1 english";

        // german translation
        $original1 = "Im Namen des barmherzigen und gnädigen Gottes.";
        $target1 = "Sure 1 vers 1";

        $this->see($original);
        $this->see($original1);

        $this->type($target, "en_pickthall_text");
        $this->type($target, "de_text");

        $this->press("Speichern");

        $this->seePageIs(URL::action("App\Http\Controllers\DruckausgabeController@showByVerse", [1,1]));

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "en_pickthall",
            "sure_vers" => "001:001",
            "text" => $target,
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "de",
            "sure_vers" => "001:001",
            "text" => $target,
            "sure" => 1,
            "vers" => 1
        ]);

        $this->see($target);
        $this->see($target1);

    }

    public function importTanzilTranslations()
    {
        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/en.pickthall.txt']);
//        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/fr.hamidullah.txt']);
//        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/nl.leemhuis.txt']);
//        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/bs.korkut.txt']);
//        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/de.bubenheim.txt']);
//        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/en.arberry.txt']);
//        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/tr.ozturk.txt']);
//        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/tr.diyanet.txt']);

    }

    public function it_shows_translation_languages()
    {
        $this->see('de');
        $this->see('en_pickthall');
//        $this->see('fr_hamidullah');
//        $this->see('nl_leemhuis');
//        $this->see('bs_korkut');
//        $this->see('de_bubenheim');
//        $this->see('en_arberry');
//        $this->see('tr_ozturk');
//        $this->see('tr_diyanet');
    }

    public function it_shows_the_correct_texts()
    {
        $this->see('Im Namen des barmherzigen und gnädigen Gottes.');
        $this->see('In the name of Allah, the Beneficent, the Merciful.');
//        $this->see('Au nom d\'Allah, le Tout Miséricordieux, le Très Miséricordieux.');
//        $this->see('In de naam van God, de erbarmer, de barmhartige.');
//        $this->see('U ime Allaha, Milostivog, Samilosnog!');
//        $this->see('Im Namen Allahs, des Allerbarmers, des Barmherzigen.');
//        $this->see('In the Name of God, the Merciful, the Compassionate');
//        $this->see('Rahman ve Rahîm Allah\'ın adıyla...');
//        $this->see('Rahman ve Rahim olan Allah\'ın adıyla:');

    }
}
