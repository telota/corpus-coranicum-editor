<?php

use App\Models\Manuskripte\Manuskriptseiten;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateManuscript31Test extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_merges_the_two_image_entries_of_fol_66r_into_manuscript_page_19892()
    {

        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call('fix:manuscript-31');

        $this->seeInDatabase("manuskriptseiten_bilder", [
           "id" => 8430,
           "manuskriptseite" => 19892
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
           "id" => 2982,
           "manuskriptseite" => 19892
        ]);

        $this->dontSeeInDatabase("manuskriptseiten_bilder", [
            "id" => 2983
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 4016
        ]);

        $this->assertCount(2, Manuskriptseiten::find(19892)->bilder);
    }

    /** @test */
    public function it_swaps_the_images_for_fol_67r_and_67v()
    {
        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call('fix:manuscript-31');

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2984,
            "manuskriptseite" => 19893
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2985,
            "manuskriptseite" => 19893
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 8431,
            "manuskriptseite" => 4017
        ]);
    }

    /** @test */
    public function it_swaps_the_images_for_fol_68r_and_68v()
    {
        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call('fix:manuscript-31');

        $this->seeInDatabase("manuskriptseiten_bilder", [
           "id" => 2986,
           "manuskriptseite" => 19894
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2987,
            "manuskriptseite" => 19894
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 8432,
            "manuskriptseite" => 4018
        ]);
    }

    /** @test */
    public function it_merges_the_two_image_entries_of_fol_69r_into_manuscript_page_4019()
    {
        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call('fix:manuscript-31');

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2988,
            "manuskriptseite" => 4019
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2989,
            "manuskriptseite" => 4019
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 8433,
            "manuskriptseite" => 4019
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 22938,
            "manuskriptseite" => 4019
        ]);

        $this->dontSeeInDatabase("manuskriptseiten", [
            "SeitenID" => 19895
        ]);
    }

    /** @test */
    public function swap_bergstraesser_images_for_fol_67_and_68()
    {
        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call("fix:manuscript-31");

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2984,
            "manuskriptseite" => 4017
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
           "id" => 2986,
           "manuskriptseite" => 4018
        ]);
    }

    /** @test */
    public function correct_bergstraesser_images_for_fol_67_to_69()
    {
        $this->markTestSkipped('Test for already executed one time fix.');

        Artisan::call("fix:manuscript-31");

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2987,
            "manuskriptseite" => 19893
        ]);

        $this->seeInDatabase("manuskriptseiten_bilder", [
            "id" => 2989,
            "manuskriptseite" => 19894
        ]);
    }
}
