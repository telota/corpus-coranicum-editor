<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fields = [
            "translations" => [
                "de",
                "en",
                "fr",
                "ar",
                "fa",
                "ru",
                "tr",
                "ur",
                "ind",
            ],
            "lc_leser" => [
                "abkuerzung",
                "ort",
                "biografie",
                'namekomplett',
                "todesdatum",
                "todesdatum_AH",
                "ueberlieferer",
                "ueberlieferertyp",
            ],
            "belegstellen" => [
                "Datierung",
                "Edition",
                "Uebersetzung",
                "Identifikator",
                "Textsorte",
                "HinweiseaufEdition",
                "SchlagwortPersonen",
                "SchlagwortOrte",
                "SchlagwortSonst",
                "Stichwort",
                "TextstelleKoran",
                "Anmerkungen",
                "Anmerkungen_en",
                "Uebersetzer",
                "Bearbeiter",
                "Einstelldatum",
                "Anderungsdatum",
                "Originalsprache",
                "Transkription",
                "Uebersetzung_dt",
                "Uebersetzung_en",
                "Uebersetzung_fr",
                "Uebersetzung_ar",
                "Autor",
                "allfields",
                "Bibeltext",
                "Vermittlungssprache",
                "Literatur",
            ],
        ];

        foreach ($fields as $table => $columns) {
            Schema::table($table, function (Blueprint $t) use ($columns) {
                foreach ($columns as $c) {
                    $t->text($c)->nullable()->change();
                }
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
