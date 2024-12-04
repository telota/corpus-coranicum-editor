<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private static function allFieldsEmpty($b){
        $fields = [
            'typ',
            'belegstelle',
            'bearbeiter',
            'ort',
            'datierung',
            'uebersetzung_nachweis',
            'originaltext',
            'umschrift',
            'bildlink',
            'dateiname',
            'edition',
            'uebersetzung',
            'anmerkung',
            'sprache'
        ];

        foreach ($fields as $f){
            if ($b->$f !== ""){
                return false;
            }
        }
        return true;
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        foreach (\App\Models\Glossarbeleg::all() as $b) {

           if(self::allFieldsEmpty($b)){
               Log::info("Deleting: ", $b->toArray());
               $b->delete();
           }
        }

        Schema::table('glossarbelege', function (Blueprint $table) {
            $table->foreign('glossarium_id')->references('id')->on('glossarium');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
