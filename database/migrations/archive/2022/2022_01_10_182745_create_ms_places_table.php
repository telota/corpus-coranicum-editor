<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuskripte\Aufbewahrungsort;
use \App\Models\Manuscripts\Place;

class CreateMsPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_places', function (Blueprint $table) {
            $table->increments('id');
            $table->string("place")->nullable();
            $table->string("place_name")->nullable()->unique();
            $table->string("country_code", 2)->nullable();
            $table->text('description', 65535)->nullable();
            $table->text('link', 1000)->nullable();
            $table->text('image_link', 1000)->nullable();
            $table->text('image_original_link', 1000)->nullable();
            $table->text('image_description', 65535)->nullable();
            $table->decimal("longitude", 10, 7)->nullable();
            $table->decimal("latitude", 10, 7)->nullable();
            $table->string("geonames")->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(["place_name", "longitude", "latitude", "geonames"]);
        });

        DB::statement("ALTER TABLE `ms_places` COMMENT 'old table: aufbewahrungstorte. It represents the location where the manuscripts are stored.'");

        // transfer data from 'aufbewahrungsort' to 'ms_places'

        $lastId = DB::table('aufbewahrungsorte')->orderBy('id', 'DESC')->first()->id;

        foreach(Aufbewahrungsort::all() as $ort)
        {
            $newPlace = Place::create([
                'place' => $ort->ort,
                'place_name' => $ort->name,
                'country_code' => $ort->country_code,
                'description' => $ort->beschreibung,
                'link' => $ort->link,
                'image_link' => $ort->bild_link,
                'image_original_link' => $ort->bild_orig,
                'image_description' => $ort->bild_beschreibung,
                'longitude' => $ort->longitude,
                'latitude' => $ort->latitude,
                'geonames' => $ort->geonames
            ]);
            $newPlace->id = $ort->id + $lastId;
            $newPlace->save();
        }

        foreach(Place::all() as $ort) {
            $ort->id = $ort->id - $lastId;
            $ort->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_places');
    }
}
