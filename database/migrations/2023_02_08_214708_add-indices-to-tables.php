<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        /* These tables appear  to have an invalid default value for their timestamps,
         which for some reason messes up the indexing migraiton.
        */
        foreach (['manuskriptseiten_bilder', 'belegstellen'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->timestamp('created_at')
                    ->default('CURRENT_TIMESTAMP')
                    ->nullable()
                    ->change();
                $t->timestamp('updated_at')
                    ->default('CURRENT_TIMESTAMP')
                    ->nullable()
                    ->change();
            });


        }


        $to_index = [
            "manuskript" => ["AufbewahrungsortId"],
            "manuskriptseiten" => ["ManuskriptID"],
            "manuskriptseiten_mapping" => ["manuskriptseite"],
            "manuskriptseiten_bilder" => ["manuskriptseite"],
            "belegstellen" => ["kategorie"],
            "belegstellen_mapping" => ["belegstelle"],
            "lc_variante" => ["leseart"],
            "lc_leseart_leser" => ["leseart", "leser"],
            "lc_leseart_quelle" => ["leseart", "quelle"],
        ];

        foreach ($to_index as $table => $columns) {
            Schema::table($table, function (Blueprint $t) use ($columns) {
                foreach ($columns as $column) {
                    $t->index($column)->change();
                }
            });
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
};
