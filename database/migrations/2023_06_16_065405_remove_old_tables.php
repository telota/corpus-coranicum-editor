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
        $tables = [
            'Belegstellen_update',
            'associates',
            'bib_functions',
            'bib_indices',
            'bib_keywords',
            'bib_persons',
            'bib_titles',
            'bib_titles_keywords',
            'bib_titles_persons',
            'bib_users',
            'image_details',
            'permalink_data',
            'translator_translations',
            'translator_languages',
            'uebersetzungen_info',
        ];

        foreach ($tables as $t){
            Schema::drop($t);
        }
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
