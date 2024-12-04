<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Associate;


class MitarbeiterUnitTest extends TestCase
{
    use DatabaseTransactions;

    private $association;

    /** @test */
    public function setUp()
    {

        parent::setUp();
        $this->association = factory(Associate::class)->create();
        $this->association->save();
    }

    /**
     * @test
     */
    public function it_creates_and_stores_an_association_in_database()
    {
        $association2 = factory(Associate::class)->create();
        $association2->save();

        $this->seeInDatabase('associates', [
            'name' => $association2->name
        ]);
    }

    /**
    * @test
    */
    public function it_updates_an_existing_association_accordingly()
    {

        $this->association->name = $this->faker->name;

        if ($this->association->name != "Test") {
            $this->association->name = "Test";
            $this->association->save();
            $this->seeInDatabase('associates', [
                'name' => "Test"
            ]);

        } else {
            $this->association->name = "Test2";
            $this->association->save();
            $this->seeInDatabase('associates', [
                'name' => "Test2"
            ]);
        }


    }



}
