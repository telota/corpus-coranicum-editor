<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Manuskripte\Manuskript;

/**
 * Die Manuskriptseiten sollen mit 87v anfangen, statt 1v. Die ersten 86 Folien werden später hochgeladen werden.
 * */
class ModifyFolioNumberFromManuskriptID56 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $manuscript = Manuskript::find(56);
        $manuscriptPages = $manuscript->manuskriptseiten;
        foreach ($manuscriptPages as $manuscriptPage) {
            $manuscriptPage->Folio = $manuscriptPage->Folio + 86;
            $manuscriptPage->save();
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
