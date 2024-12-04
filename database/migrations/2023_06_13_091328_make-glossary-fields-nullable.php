<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fields = [
            "glossarium" => [
                "wurzel",
                "literatur",
                "literatur",
                "anmerkungen",
                "bearbeiter",
            ],
            "glossarbelege" => [
                "typ",
                "bearbeiter",
                "ort",
                "datierung",
                "uebersetzung_nachweis",
                "originaltext",
                "umschrift",
                "bildlink",
                "dateiname",
                "edition",
                "uebersetzung",
                "anmerkung",
                "sprache",
            ]
        ];

        foreach ($fields as $table => $columns) {
            Schema::table($table, function (Blueprint $t) use ($columns) {
                foreach ($columns as $c) {
                    $t->text($c)->nullable()->change();
                }
            });
        }

        Schema::table('glossarbelege',function (Blueprint $t){
            $t->dropColumn('dateiname');
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
