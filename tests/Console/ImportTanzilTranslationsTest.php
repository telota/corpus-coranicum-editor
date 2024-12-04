<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImportTanzilTranslationsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_imported_the_en_pickthall_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/en.pickthall.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "en_pickthall",
            "sure_vers" => '001:001',
            "text" => "In the name of Allah, the Beneficent, the Merciful.",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "en_pickthall",
            "sure_vers" => '114:006',
            "text" => "Of the jinn and of mankind.",
            "sure" => 114,
            "vers" => 6
        ]);
    }



    /** @test */
    public function it_imported_the_fr_hamidullah_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/fr.hamidullah.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "fr_hamidullah",
            "sure_vers" => '001:001',
            "text" => "Au nom d'Allah, le Tout Miséricordieux, le Très Miséricordieux.",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "fr_hamidullah",
            "sure_vers" => '114:006',
            "text" => "qu'il (le conseiller) soit un djinn, ou un être humain».",
            "sure" => 114,
            "vers" => 6
        ]);
    }


    /** @test */
    public function it_imported_the_nl_leemhuis_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/nl.leemhuis.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "nl_leemhuis",
            "sure_vers" => '001:001',
            "text" => "In de naam van God, de erbarmer, de barmhartige.",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "nl_leemhuis",
            "sure_vers" => '114:006',
            "text" => "of hij nu tot de djinn of tot de mensen behoort.\"",
            "sure" => 114,
            "vers" => 6
        ]);
    }


    /** @test */
    public function it_imported_the_bs_korkut_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/bs.korkut.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "bs_korkut",
            "sure_vers" => '001:001',
            "text" => "U ime Allaha, Milostivog, Samilosnog!",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "bs_korkut",
            "sure_vers" => '114:006',
            "text" => "od džina i od ljudi!\"",
            "sure" => 114,
            "vers" => 6
        ]);
    }


    /** @test */
    public function it_imported_the_de_bubenheim_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/de.bubenheim.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "de_bubenheim",
            "sure_vers" => '001:001',
            "text" => "Im Namen Allahs, des Allerbarmers, des Barmherzigen.",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "de_bubenheim",
            "sure_vers" => '114:006',
            "text" => "von den Ginn und den Menschen.",
            "sure" => 114,
            "vers" => 6
        ]);
    }


    /** @test */
    public function it_imported_the_en_arberry_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/en.arberry.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "en_arberry",
            "sure_vers" => '001:001',
            "text" => "In the Name of God, the Merciful, the Compassionate",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "en_arberry",
            "sure_vers" => '114:006',
            "text" => "of jinn and men.'",
            "sure" => 114,
            "vers" => 6
        ]);
    }


    /** @test */
    public function it_imported_the_tr_ozturk_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/tr.ozturk.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "tr_ozturk",
            "sure_vers" => '001:001',
            "text" => "Rahman ve Rahîm Allah'ın adıyla...",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "tr_ozturk",
            "sure_vers" => '114:006',
            "text" => "Cinlerden de insanlardan da olur o!\"",
            "sure" => 114,
            "vers" => 6
        ]);
    }


    /** @test */
    public function it_imported_the_tr_diyanet_translations()
    {
//        $this->markTestSkipped("One time fix");

        Artisan::call('import:tanzil_translations', ['file' => 'tanzilTranslations/tr.diyanet.txt']);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "tr_diyanet",
            "sure_vers" => '001:001',
            "text" => "Rahman ve Rahim olan Allah'ın adıyla:",
            "sure" => 1,
            "vers" => 1
        ]);

        $this->seeInDatabase("koran_uebersetzung", [
            "sprache" => "tr_diyanet",
            "sure_vers" => '114:006',
            "text" => "De ki: \"İnsanlardan ve cinlerden ve insanların gönüllerine vesvese veren o sinsi vesvesecinin şerrinden, insanların Tanrısı, insanların Hükümranı ve insanların Rabbi olan Allah'a sığınırım.\"",
            "sure" => 114,
            "vers" => 6
        ]);
    }
}
