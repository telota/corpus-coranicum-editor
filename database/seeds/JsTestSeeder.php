<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class JsTestSeeder extends Seeder
{
    /**
     * Run the database seeds for running JS tests.
     *
     * @return void
     */
    public function run()
    {

        if (env("APP_ENV") == "development")
        {

            $this->createTestUser();

        }


    }

    /**
     * @return mixed
     */
    private function createTestUser()
    {

        $paleocoranUser = User::where("name", "paleocoran_tester")->first();
        $paleocoranRole = Role::where("name", "paleocoran_role")->first();

        if (!$paleocoranUser)
        {

            $newPaleocoranUser = new User();
            $newPaleocoranUser->name = "paleocoran_tester";
            $newPaleocoranUser->email = "testing-the-paleocoran@bbaw.de";
            $newPaleocoranUser->password = bcrypt("FeY5dtLrUwb78HDXfAgX");
            $newPaleocoranUser->remember_token = str_random(10);

            $newPaleocoranUser->save();

            $paleocoranUser = User::where("name", "paleocoran_tester")->first();
            $paleocoranUser->attachRole($paleocoranRole);


        }

        $paleocoranUser = User::where("name", "paleocoran_tester")->first();

        if (!$paleocoranUser->hasRole("paleocoran_role"))
        {
            $paleocoranUser->attachRole($paleocoranRole);
        }

    }

}
