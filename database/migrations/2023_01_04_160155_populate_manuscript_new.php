<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \App\Models\Manuscripts\Place;
use \App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuskripte\Manuskript;

class PopulateManuscriptNew extends Migration
{
    private $lastOldId;

    private $place_and_signature = [];

    private function uniqueCallNumberForPlace($callNumber, $place_id)
    {
        $new = $callNumber;
        if (trim($new) == "") {
            Log::info("Call number field is empty. Assigning '(No Signatur Given)'.");
            $new = "(No Signatur Given)";
        }

        $shouldBeUnique = $place_id . $new;
        while (array_key_exists($shouldBeUnique, $this->place_and_signature)) {
            $new = $new . "-I";
            $shouldBeUnique = $place_id . $new;
        };
        $this->place_and_signature[$shouldBeUnique] = true;
        return $new;
    }

    private function createNewManuscript($old, $places)
    {
        Log::info("Working on manuscript " . $old->ID);
        Log::info("Signatur: '" . $old->Signatur . "'");
        $newManuscript = ManuscriptNew::create([
            'created_by' => "DATA_MIGRATION",
            'credit_line_image' => $old->Bildnachweis,
            'commentary_internal' => $old->Kommentar_intern,
            'catalogue_entry' => $old->Kommentar,
            'codicology' => $old->Kodikologie,
            'paleography' => $old->Palaographie,
            'transliteration' => $old->transliteration_alt,
            'call_number' => $old->Signatur,
            'dimensions' => $old->Format,
            'is_online' => 0,
        ]);

        // Don't assign ID in create. It autoincrements.
        // Note that is in unsafe if there are big gaps in the old ids.
        $newManuscript->id = $old->ID + $this->lastOldId;

        // Add place
        $place = $places->first(
            function ($key, $value) use ($old) {
                return $value->id == $old->AufbewahrungsortId;
            }
        );
        if ($place) {
            Log::info("Here is the place: {$place->id}");
            $newManuscript->place_id = $place->id;
        } else {
        }


        // Add unique call number
        $callNumber = $this->uniqueCallNumberForPlace(
            $newManuscript->call_number,
            $newManuscript->place_id
        );
        $newManuscript->call_number = $callNumber;

        $newManuscript->save();
    }


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::info("Running migration to populate the manuscript table.");

        ManuscriptNew::all()->each(function ($item) {
            $item->delete();
        });

        DB::statement("ALTER TABLE ms_manuscript AUTO_INCREMENT =  1");

        DB::transaction(function () {
            $places = Place::all();
            $oldManuscripts = Manuskript::orderBy('ID')->get();
            $this->lastOldId = $oldManuscripts->last()->ID;
            foreach ($oldManuscripts as $old) {
                $this->createNewManuscript($old, $places);
            }

            foreach (ManuscriptNew::all() as $m) {
                $m->id = $m->id - $this->lastOldId;
                $m->updated_by = "DATA_MIGRATION";
                $m->save();
            }
        });
        $increment = ManuscriptNew::max('id') + 1;
        DB::statement("ALTER TABLE ms_manuscript AUTO_INCREMENT =  {$increment}");
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
