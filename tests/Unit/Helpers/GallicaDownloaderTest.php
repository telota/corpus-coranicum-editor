<?php

use App\Models\Helpers\GallicaDownloader;
use App\Models\Manuskripte\Manuskriptseiten;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

class GallicaDownloaderTest extends TestCase
{

    use DatabaseTransactions;

    private $exampleDownloader;

    /** @test */
    public function setUp()
    {

        parent::setUp();

        $this->exampleDownloader = new GallicaDownloader(
            "http://gallica.bnf.fr/ark:/12148/btv1b8452552h/f9.image.r=arabe%20324",
            9, 12,
            786,
            4, "r",
            5, "v"
        );

    }

    /** @test */
    public function it_fails_the_download_process_when_no_valid_gallica_link_is_given()
    {

        $this->setExpectedException(Mockery\Exception::class);

        $gd = new GallicaDownloader("www.corpuscoranicum.de", 3, 4);
        $gd->downloadImages();

    }

    /** @test */
    public function it_fails_the_download_process_when_the_gallica_page_range_is_invalid()
    {

        $this->setExpectedException(Mockery\Exception::class);

        $gd = new GallicaDownloader("http://gallica.bnf.fr/ark:/12148/btv1b8452552h/f9.image.r=arabe%20324", 4, 3);
        $gd->downloadImages();

    }

    /** @test */
    public function it_has_no_manuscript_page_range_when_no_folio_or_page_data_are_specified()
    {

        $gd = new GallicaDownloader("http://gallica.bnf.fr/ark:/12148/btv1b8452552h/f9.image.r=arabe%20324", 3, 4);
        $this->assertFalse($gd->hasPageRange());

    }

    /** @test */
    public function it_has_a_manuscript_page_range_when_folio_or_page_data_are_specified()
    {
        $gd = new GallicaDownloader(
            "http://gallica.bnf.fr/ark:/12148/btv1b8452552h/f9.image.r=arabe%20324",
            3,
            4,
            1,
            1,
            "r",
            1,
            "v");

        $this->assertTrue($gd->hasPageRange());
    }

    /** @test */
    public function it_creates_a_gallica_range()
    {

        $target = [9, 10, 11, 12];
        $this->assertEquals($target, $this->exampleDownloader->getGallicaRange());

    }

    /** @test */
    public function it_creates_a_gallica_manuscript_page_map()
    {

        $target = [
            9 => [
                "Folio" => 4,
                "Seite" => "r",
            ],
            10 => [
                "Folio" => 4,
                "Seite" => "v",
            ],
            11 => [
                "Folio" => 5,
                "Seite" => "r",
            ],
            12 => [
                "Folio" => 5,
                "Seite" => "v",
            ],
        ];

        $this->assertEquals($target, $this->exampleDownloader->getGallicaPageMap());

    }

    /** @test */
    public function it_can_create_a_download_link_for_the_image()
    {

        $target = "http://gallica.bnf.fr/iiif/ark:/12148/btv1b8452552h/f9/full/full/0/native.jpg";
        $this->assertEquals($target, $this->exampleDownloader->getFullImageLink(9));

    }

    /** @test */
    public function it_creates_a_download_link_when_the_manuscript_does_not_exists()
    {

        $target = "btv1b8452552h/btv1b8452552h_f3";

        $gd = new GallicaDownloader("http://gallica.bnf.fr/ark:/12148/btv1b8452552h/f9.image.r=arabe%20324", 3, 4);
        $this->stringContains($target, $gd->getDownloadPath(3));

    }

    /** @test */
    public function it_creates_a_download_link_when_a_manuscript_id_is_given()
    {

        $target = "Paris_Bibliotheque_nationale_de_France_Arabe_324_a/Paris_Bibliotheque_nationale_de_France_Arabe_324_a_f4r";

        $this->stringContains($target, $this->exampleDownloader->getDownloadPath(9));

    }

    /** @test */
    public function it_downloads_images_to_silo10()
    {

        $this->exampleDownloader->downloadImages();
        $this->assertTrue(Storage::disk('silo10')->has($this->exampleDownloader->getDownloadPath(9)));

    }

    /** @test */
    public function it_attaches_images_to_the_manuscript()
    {

        $seiteBefore = Manuskriptseiten::where([
            "ManuskriptID" => 786,
            "Folio" => 4,
            "Seite" => "r"
        ])->first();

        $countBefore = $seiteBefore->bilder->count();

        $this->exampleDownloader->downloadImages();

        $seiteReloaded = Manuskriptseiten::where([
            "ManuskriptID" => 786,
            "Folio" => 4,
            "Seite" => "r"
        ])->first();

        $this->assertTrue($seiteReloaded->bilder->count() > $countBefore);

    }

}
