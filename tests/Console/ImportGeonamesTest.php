<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImportGeonamesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_imported_the_geonames_of_aufbewahrungsort_1()
    {
        Artisan::call('import:geonames', ['file' => 'location_list_fix.csv']);

        $this->seeInDatabase("aufbewahrungsorte", [
            "id" => "1",
            "longitude" => 50.5917,
            "latitude" => 26.2397,
            "geonames" => '11874014'
        ]);
    }
}
