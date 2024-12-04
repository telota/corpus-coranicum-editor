<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssociationTest extends TestCase
{
    use DatabaseTransactions;
    /** @test*/
    public function it_can_create_and_edit_an_existing_user(){
        $this->actingAs($this->getPaleocoranTestUser())->visit("/manage/associates");
        $this->click("Neu");
        $this->see("Mitarbeiter erstellen");
        $this->type("Test User", 'name');
        $this->select("Mitarbeiter/in", 'status');
        $this->type("http://test.de",'website');
        $this->press("Speichern");
        $this->seeInDatabase('associates', [
            'name' => "Test User"
        ]);
        $this->click("Bearbeiten");
        $this->type("Test User2", 'name');
        $this->press("Speichern");
        $this->seeInDatabase('associates', [
            'name' => "Test User2"
        ]);
        $this->dontSeeInDatabase('associates', [
            'name' => "Test User"
        ]);
    }
}
