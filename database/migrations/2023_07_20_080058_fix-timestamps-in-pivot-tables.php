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
        $tables = [
            'ms_attributed_to',
            'ms_diacritics',
            'ms_funders',
            'ms_manuscript_attributed_to',
            'ms_manuscript_colophon_text_translations',
            'ms_manuscript_diacritics',
            'ms_manuscript_funders',
            'ms_manuscript_palimpsest_text_translations',
            'ms_manuscript_reading_signs',
            'ms_manuscript_reading_signs_functions',
            'ms_manuscript_rwt_provenances',
            'ms_manuscript_sajda_signs_text_translations',
            'ms_manuscript_script_styles',
            'ms_manuscript_verssegmentations',
            'ms_original_codexes',
            'ms_provenances',
            'ms_reading_signs',
            'ms_script_styles',
        ];

        foreach ($tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->timestamp('created_at')
                    ->default('CURRENT_TIMESTAMP')
                    ->change();
                $table->timestamp('updated_at')
                    ->default('CURRENT_TIMESTAMP')
                    ->change();
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
