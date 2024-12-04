<?php

use App\Models\Manuskripte\Manuskript;
use App\Models\Manuskripte\Manuskriptseiten;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class ManuskriptseitenUnitTest extends TestCase
{

    use DatabaseTransactions;

    private $manuskript;
    private $manuskriptseite;

    /** @test */
    public function setUp()
    {

        parent::setUp();

        $this->manuskript = Manuskript::find(150);
        $this->manuskriptseite = $this->manuskript->manuskriptseiten->first();

    }

    /** @test */
    public function it_has_images()
    {
        $this->assertNotNull($this->manuskriptseite->bilder);
    }


}
