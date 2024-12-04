<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Manuskripte\Manuskript;

/**
 * Remove all Folio entries from Manuskript ID 1335, 1337, and 1339
 * */
class RemoveFolioEntriesFromKairoManuskriptseiten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $manuscriptList = [1335, 1337, 1339];

        foreach ($manuscriptList as $manuscriptID) {
            $manuscript = Manuskript::find($manuscriptID);
            $manuscriptPages = $manuscript->manuskriptseiten;
            foreach ($manuscriptPages as $manuscriptPage) {
               $manuscriptPage->Folio = "";
               $manuscriptPage->save();
            }
        }
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
