<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use \App\Models\Manuskripte\Aufbewahrungsort;
use \App\Models\Manuscripts\Place;
use \App\Models\Manuscripts\ManuscriptNew;

class RepopulateManuscriptPlaces extends Migration
{
    private $lastOldId;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {

            // We first have to delete manuscripts referencing places to avoid a foreign key constraint problem
            ManuscriptNew::all()->each(function ($item) {
                $item->delete();
            });
            Place::all()->each(function ($item) {
                $item->delete();
            });
            DB::statement("ALTER TABLE ms_places AUTO_INCREMENT =  1");

            $old = Aufbewahrungsort::orderBy('id')->get();
            $this->lastOldId = $old->last()->id;
            foreach ($old as $ort) {
                $newPlace = Place::create([
                    'created_by' => "DATA_MIGRATION",
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
                $newPlace->id = $ort->id + $this->lastOldId;
                $newPlace->save();
            }
            foreach (Place::all() as $place) {
                $place->id = $place->id - $this->lastOldId;
                $place->updated_by = "DATA_MIGRATION";
                $place->save();
            }

            $increment = Place::max('id') + 1;
            DB::statement("ALTER TABLE ms_places AUTO_INCREMENT =  {$increment}");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
