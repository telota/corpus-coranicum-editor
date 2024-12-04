<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class LoadUmwelttextTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_and_stores_an_htmlFile_in_local_storage()
    {
        Artisan::call("umwelttext:load");

        $this->assertTrue(Storage::disk('local')->exists('umwelttext/umwelttext.html'));

        Storage::deleteDirectory('umwelttext');
    }
}
